<?php

namespace App\Http\Controllers;

use App\Models\ChangePlanRequest;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use TeamTNT\TNTSearch\TNTGeoSearch;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::query()->whereNot('type', '=', User::USER_ADMIN);
        $users->where('is_activated', '=', true);
        $users->where(function ($query) use ($request) {
            switch ($request->get('filter')) {
                case "Subscribed":
                    $query->whereDate('subscription_deadline', '>', Carbon::parse(now()->format('Y-m-d')));
                    break;
                case "Not Subscribed":
                    $query->whereDate('subscription_deadline', '<', Carbon::parse(now()->format('Y-m-d')));
                    break;
            }

            $query->where('en_name', 'like', '%'.$request->get('name').'%')->orWhere('ar_name', 'like', '%'.$request->get('name').'%');
        });


        return response($users->with(['firstMediaOnly', 'plan'])->orderByDesc('updated_at')->get());
    }

    public function unsubscribedUsersCount()
    {
        return response(User::query()->whereNot('type', '=', User::USER_ADMIN)->where(function ($query) {
            $query->where('is_activated', '=', true)->whereDate('subscription_deadline', '<', Carbon::parse(now()->format('Y-m-d')));
        })->count())->json();
    }

    public function register(Request $request)
    {
        $user = User::query()->create($request->only([
            'plan_id',
            'en_name',
            'en_country',
            'en_city',
            'en_address',
            'en_bio',
            'ar_name',
            'ar_country',
            'ar_city',
            'ar_address',
            'ar_bio',
            'phone',
            'type',
            'email',
            'password',
            'subscription_period',
            'latitude',
            'longitude'
        ]));

        $user->password = bcrypt($request->get('password'));
        $user->save();

        $user->addMediaFromRequest('profile_pic')->toMediaCollection();

        return response('ok');
    }

    public function activate(Request $request, User $user)
    {
        $user->is_activated = true;
        $user->subscription_deadline = Carbon::parse(now()->format('Y-m-d'))->addMonths($user->subscription_period);
        $user->featured = $request->get('featured');
        $user->save();
        Artisan::call('index:users');
        return response('ok');
    }

    public function update(Request $request, User $user)
    {
        $id = $user->id;
        $user->update($request->only([
            'en_name',
            'en_country',
            'en_city',
            'en_address',
            'en_bio',
            'ar_name',
            'ar_country',
            'ar_city',
            'ar_address',
            'ar_bio',
            'phone',
            'type',
            'email',
            'featured'
        ]));

        if ($request->get('update_profile_pic')) {
            $user->clearMediaCollection();
            $user->addMediaFromRequest('profile_pic')->toMediaCollection();
        }

        Artisan::call('index:users');

        return response('ok');
    }

    public function changeCoords(Request $request, User $user)
    {
        $user->update($request->only(['latitude', 'longitude']));
        return response('ok');
    }

    public function changePassword(Request $request, User $user)
    {
        if (Hash::check($request->get('oldPassword'), $user->password)) {
            $user->update(['password' => bcrypt($request->get('newPassword'))]);
            return response('ok');
        } else {
            return abort(422);
        }

    }

    public function renewSubscription(Request $request)
    {
        foreach ($request->get('ids') as $user) {
            $user = User::query()->find($user);
            $user->update([
                'subscription_deadline' => Carbon::parse(now()->format('Y-m-d'))->addMonths($user->subscription_period)
            ]);
        }
        return response('ok');
    }

    public function changePlan(ChangePlanRequest $changePlanRequest)
    {
        $user = User::query()->find($changePlanRequest->user_id);

        $user->update([
            'plan_id' => $changePlanRequest->plan_id,
            'subscription_deadline' => Carbon::parse(now()->format('Y-m-d'))->addMonths($changePlanRequest->subscription_period),
            'subscription_period' => $changePlanRequest->subscription_period
        ]);

        $changePlanRequest->delete();

        return response('ok');
    }

    public function rejectChangePlan(ChangePlanRequest $changePlanRequest)
    {
        return response($changePlanRequest->delete());
    }

    public function destroy(Request $request)
    {
        User::query()->whereIn('id', $request->get('ids'))->delete();
        Artisan::call('index:users');
        return response('ok');
    }

    public function search(Request $request)
    {
        $currentLocation = [
            'longitude' => floatval($request->get('longitude')),
            'latitude'  => floatval($request->get('latitude'))
        ];
        $distance = 50; //km

        $usersIndex = new TNTGeoSearch();

        $usersIndex->loadConfig([
            'driver'    => env('DB_CONNECTION', 'mysql'),
            'host'      => env('DB_HOST', 'localhost'),
            'database'  => env('DB_DATABASE', 'dentist'),
            'username'  => env('DB_USERNAME', 'root'),
            'password'  => env('DB_PASSWORD', 'root'),
            'storage'   => storage_path(),
            'stemmer'   => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class,
            'tokenizer' => \TeamTNT\TNTSearch\Support\ProductTokenizer::class
            ]);

        $usersIndex->selectIndex('candyShops.index');

        $users = $usersIndex->findNearest($currentLocation, $distance, 50);


        return response(User::query()->whereIn('id', $users['ids'])->where(function ($query) use ($request) {
            $query->where('type', '=', $request->get('type'))->where('en_name', 'like', '%'.$request->get('name').'%')->orWhere('ar_name', 'like', '%'.$request->get('name').'%');
        })->with(['firstMediaOnly'])->get());

//        return response(User::search($request->get('q'))->where('is_activated', '=', true)->where('type', '=', $request->get('type'))->get());
    }

    public function specialDoctorsAndCompanies()
    {
        return response([
            'specialDoctors' => User::query()->where('type', '=', User::USER_DOCTOR)->where('featured', '=', true)->with(['firstMediaOnly'])->get(),
            'specialCompanies' => User::query()->where('type', '=', User::USER_COMPANY)->where('featured', '=', true)->with(['firstMediaOnly'])->get()
        ]);
    }

    public function show(User $user)
    {
        return response($user->loadMissing(['firstMediaOnly']));
    }

    public function doctorProjects(User $user)
    {
        $projects = $user->projects;
        $updatedProjects = $projects->transform(function ($item, $key) {
        $item['before'] = $item->getFirstMedia('before');
        $item['after'] = $item->getFirstMedia('after');

        return $item; });

        return response($updatedProjects);
    }

    public function companyProjects(User $user)
    {
        $projects = $user->projects;
        $updatedProjects = $projects->transform(function ($item, $key) {
            $item['image'] = $item->getFirstMedia('image');

            return $item; });

        return response($updatedProjects);
    }

    public function requests()
    {
        $newUsers = User::query()->where('type', '<>', User::USER_ADMIN)->where('is_activated', '=', false)->with(['firstMediaOnly', 'plan'])->get();
        $changePlan = ChangePlanRequest::query()->with(['user' => function ($query) {
            $query->with(['firstMediaOnly']);
        }, 'plan'])->get();

        return response(['new_users' => $newUsers, 'change_plan' => $changePlan]);
    }

    public function requestChangePlan(Request $request, $user)
    {
        ChangePlanRequest::query()->create(['user_id' => $user, 'plan_id' => $request->get('plan_id'), 'subscription_period' => $request->get('subscription_period')]);
        return response('ok');
    }

}
