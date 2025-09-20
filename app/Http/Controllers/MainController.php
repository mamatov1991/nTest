<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Domains\Api\Services\ApiService;
class MainController extends Controller
{

    public function index()
{
    if (session()->has('auth_token') && session()->has('user')) {
        return redirect()->route('user.main');
    }

    $resp_tariffs = ApiService::getFromApi('site/tariffs');
    $tariffs = $resp_tariffs['data'] ?? [];

    $resp_stat = ApiService::getFromApi('site/statistics');
    $ststistiks = $resp_stat['data'] ?? [];

    $resp_news = ApiService::getFromApi('site/news');
    $news = $resp_news['data'] ?? [];

    return view('main.index', compact('tariffs', 'ststistiks', 'news'));
}

    public function login()
    {
        if (session()->has('auth_token') && session()->has('user')) {
            return redirect()->route('user.main');
        }

        return response()
            ->view('main.login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function loginPost(Request $request)
{
    $data = $request->validate([
        'phone'    => ['required', 'string', 'regex:/^\+998\d{9}$/'],
        'password' => ['required', 'string', 'min:6'],
    ]);

    try {
        $resp = ApiService::postToApi('student/login', $data);
        if (($resp['success'] ?? false) === true) {
            $token = data_get($resp, 'data.token');
            $user  = data_get($resp, 'data.student', []);

            // xavfsizlik uchun parolni olib tashlaymiz
            unset($user['password']);

            session([
                'auth_token' => $token,
                'user'       => $user,
            ]);

            return redirect()
                ->route('user.main')
                ->with('success', 'Tizimga muvaffaqiyatli kirdingiz!');
        }

        // API xato xabarini olish
        $msg = $resp['message'] ?? 'Telefon raqam yoki parol noto‘g‘ri.';
        if (is_array($msg)) {
            $msg = reset($msg) ?: 'Telefon raqam yoki parol noto‘g‘ri.';
        }

        return back()->withErrors(['login' => $msg]);

    } catch (\Throwable $e) {
        Log::error('Login failed', [
            'exception' => $e->getMessage(),
            'trace'     => $e->getTraceAsString(),
        ]);
        return back()->withErrors([
            'login' => 'Server xatosi. Keyinroq urinib ko‘ring.',
        ]);
    }
}


    public function registration(Request $request)
{
    if ($request->has('region_id')) {
        $regionId = (int) $request->query('region_id');
        if ($regionId <= 0) {
            return response()->json(['message' => 'region_id required'], 400);
        }

        try {
            $resp = ApiService::getFromApi("school/districts/{$regionId}");
            // Diagnostika uchun moslashuvchan qaytarish:
            return response()->json($resp['data'] ?? $resp);
        } catch (\Throwable $e) {
            Log::error('districts fetch failed', ['e' => $e->getMessage()]);
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    try {
        $resp = ApiService::getFromApi('school/regions');
        $regions = $resp['data'] ?? [];
    } catch (\Throwable $e) {
        Log::error('regions fetch failed', ['e' => $e->getMessage()]);
        $regions = [];
    }

    $resp1 = ApiService::getFromApi('school/subjects');
        $subjects = $resp1['data'] ?? [];

    return view('main.registration', compact('regions', 'subjects'));
}

    public function reset_send_sms(){
        return view('main.reset-send-sms');
    }

    public function reset_password(){
        return view('main.reset-password');
    }
    public function payment(){
        return view('main.payment');
    }

   public function registration_student(Request $request)
{
    $data = $request->validate([
        'name'         => ['required','string','max:255'],
        'surname'      => ['required','string','max:255'],
        'region_id'    => ['required','integer'],
        'district_id'  => ['required','integer'],
        'school_id'    => ['required','integer'],
        'class_number' => ['required','string','max:10'],
        'phone'        => ['required','string','max:20'],
        'language'     => ['required','in:uz,ru,en'],
        'password'     => ['required','string','min:6'],
        'subjects'     => ['required','array'],
        'subjects.*'   => ['integer'],
    ]);

    try {
        $resp = ApiService::postToApi('student/register', $data);

       if (($resp['success'] ?? false) === true) {
    return back()->with('success', 'Siz ro‘yxatdan muvaffaqiyatli o‘tdingiz!');
}

        $msg = $resp['message'] ?? 'Ro‘yxatdan o‘tishda xatolik.';
        return back()->withInput()->withErrors(['api' => $msg])
                     ->with('error', $msg);

    } catch (\Throwable $e) {
        Log::error('student register failed', ['e' => $e->getMessage()]);
        $errorMsg = 'Bunday telefon raqam orqali ro‘yxatdan o‘tilgan!';
        return back()
            ->withInput()
            ->withErrors(['api' => $errorMsg])
            ->with('error', $errorMsg);
    }
}

public function news_view($id)
{
    $resp_news_single = ApiService::getFromApi('site/news/{$id}');
    $news_single = $resp_news_single['data'] ?? [];

    $resp_news = ApiService::getFromApi('site/news');
    $news = $resp_news['data'] ?? [];

    return view('main.news-view', compact('news_single', 'news'));
}

}