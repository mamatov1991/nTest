<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\ApiService;

class UserController extends Controller
{
    private function requireUserOrRedirect()
    {
        $user = session('user');
        if (!$user || empty(data_get($user, 'id'))) {
            return redirect()
                ->route('login')
                ->with('error', 'Iltimos, avval tizimga kiring.');
        }
        return $user;
    }

    public function main()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

        try {
            $resp = method_exists(ApiService::class, 'getProfileMe')
                ? ApiService::getProfileMe()
                : ApiService::getFromApi('profile/me');

            if (($resp['success'] ?? false) === true) {
                $userData = $resp['data'] ?? $user;
            } else {
                $userData = $user; 
            }
            unset($userData['password']);
            session(['user' => $userData]);

        } catch (\Throwable $e) {
            Log::error('Profile fetch error', [
                'e' => $e->getMessage(),
                'user_id' => data_get($user, 'id'),
            ]);
            $userData = $user;
        }

        return view('user.index', compact('userData'));
    }

    public function data()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

        $userData = $user;
        return view('user.data', compact('userData'));
    }

    public function results()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

        $userData = $user;
        return view('user.results', compact('userData'));
    }

    public function ranking()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

        $userData = $user;
        return view('user.ranking', compact('userData'));
    }

    public function invoice()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

        $userData = $user;
        return view('user.invoice', compact('userData'));
    }

    public function setting()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

        $userData = $user;
        return view('user.setting', compact('userData'));
    }

    public function select_test_type()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

        $userData = $user;
        return view('user.select-test-type', compact('userData'));
    }

    public function test_questions($chapterId)
{
    $user = $this->requireUserOrRedirect();
    // 🔧 BUNI ALBATTA QAYTARING!
    if ($user instanceof \Illuminate\Http\RedirectResponse) {
        return $user;
    }

    // 🔧 Token bormi? (User API lar uchun shart)
    if (!session()->has('auth_token')) {
        return redirect()->route('login')->with('error', 'Sessiya tugagan. Qayta kiring.');
    }

    // Kichik validatsiya
    if (!ctype_digit((string)$chapterId)) {
        return back()->with('error', 'Noto‘g‘ri bo‘lim ID.');
    }

    try {
        // ✅ FOYDALANUVCHI TOKENI BILAN chaqiring
        $resp = ApiService::getFromApiForUser("test/start/{$chapterId}");

        // JSON kelmagan bo‘lishi ham mumkin (masalan, 500 HTML sahifa)
        if (!is_array($resp)) {
            \Log::warning('Test start non-JSON response', ['chapterId' => $chapterId]);
            return back()->with('error', 'Server javobi noto‘g‘ri.');
        }

        if (($resp['success'] ?? false) !== true) {
            \Log::warning('Test start failed', [
                'chapterId' => $chapterId,
                'status'    => $resp['status'] ?? null,
                'message'   => $resp['message'] ?? null,
            ]);
            return back()->with('error', $resp['message'] ?? 'Testni yuklashda xatolik.');
        }

        $test = $resp['data'] ?? [];

        $userData = $user;
        if (is_array($userData)) {
            unset($userData['password']); // xavfsizlik
        }

        return view('user.test-questions', compact('userData', 'test'));

    } catch (\Throwable $e) {
        \Log::error('Test load failed', [
            'chapterId' => $chapterId,
            'error'     => $e->getMessage(),
        ]);
        // 👇 vaqtincha haqiqiy xabarni ko‘rish uchun, developmentda shu qatordan foydalaning:
        // return back()->with('error', 'Xato: '.$e->getMessage());

        return back()->with('error', 'Server xatosi. Keyinroq urinib ko‘ring.');
    }
}


public function test_submit(Request $request)
{
    $user = $this->requireUserOrRedirect();
    if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

    $data = $request->validate([
        'test_id' => 'required|integer',
        'answers' => 'required|string', // JSON
    ]);

    $answers = json_decode($data['answers'], true);
    if (!is_array($answers)) {
        return back()->with('error', 'Javoblar formati noto‘g‘ri.');
    }

    try {
        $payload = [
            'test_id' => (int) $data['test_id'],
            'answers' => $answers, // [ ['question_id'=>..., 'option_id'=>...], ... ]
        ];

        // ✅ FOYDALANUVCHI TOKENI BILAN
        $resp = ApiService::postToApiForUser('test/submit', $payload);

        if (($resp['success'] ?? false) === true) {
            return redirect()->route('user.results')
                ->with('success', 'Javoblaringiz yuborildi!');
        }

        \Log::warning('Test submit failed', [
            'status'  => $resp['status'] ?? null,
            'message' => $resp['message'] ?? null,
        ]);

        return back()->with('error', $resp['message'] ?? 'Javoblarni yuborishda xatolik.');

    } catch (\Throwable $e) {
        \Log::error('Test submit failed', ['e' => $e->getMessage()]);
        return back()->with('error', 'Server xatosi. Keyinroq urinib ko‘ring.');
    }
}



    public function test_results()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

        $userData = $user;
        return view('user.test-results', compact('userData'));
    }

    public function logout()
{
    session()->forget(['auth_token', 'user']);
    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('index')->with('success', 'Siz tizimdan chiqdingiz.');
}

}
