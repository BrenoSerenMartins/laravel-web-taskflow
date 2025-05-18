<?php

namespace app\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        if ($this->userService->login($request->validated())) {
            return to_route('user.dashboard')
                ->with('success', "You are now logged in");
        }

        return to_route('login.show')
            ->with('error', 'Wrong email or password');
    }

    public function show(): Factory|View|Application
    {
        return view('auth.login.show');
    }

    public function logout(): Application|Redirector|RedirectResponse
    {
        $this->userService->logout();


        return to_route('home');
    }
}
