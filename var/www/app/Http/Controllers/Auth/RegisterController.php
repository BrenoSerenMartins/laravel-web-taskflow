<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $this->userService->create($request->validated());
        if ($this->userService->login($request->validated())) {
            return to_route('user.dashboard')
                ->with('success', "You are now logged in");
        }

        return to_route('login.show')
            ->with('error', 'Wrong email or password');
    }

    public function show(): Factory|Application|View
    {
        return view('auth.register.show');
    }
}
