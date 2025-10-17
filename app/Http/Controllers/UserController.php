<?php

namespace App\Http\Controllers;
use App\Domains\Api\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // Foydalanuvchi tekshiruvi
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
        // $token = session('auth_token');
        // dd($token);
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;
        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }
        return view('user.index', compact('userData'));
    }

    public function data()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;
        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }
        return view('user.data', compact('userData'));
    }

    public function results()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }
        return view('user.results', compact('userData'));
    }

    public function ranking()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }
        return view('user.ranking', compact('userData'));
    }

    public function invoice()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }
        return view('user.invoice', compact('userData'));
    }

    public function setting()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }
        return view('user.setting', compact('userData'));
    }

    public function setting_post(Request $request)
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }
        return view('user.setting', compact('userData'));
    }

    public function getTestsByCategory(Request $request, $subjectId)
    {
        $testCategory = $request->get('testCategory', 0);

        // Chapters
        $response_chapters = ApiService::getFromApiForUser("test/chapters/{$subjectId}/{$testCategory}");
        $chapters = data_get($response_chapters, 'data', []);

        // Final tests
        $response_final_tests = ApiService::getFromApiForUser("final-test/available-tests/{$subjectId}/{$testCategory}");
        $final_tests = data_get($response_final_tests, 'data', []);
        // dd($final_tests);

        return response()->json([
            'chapters' => $chapters,
            'final_tests' => $final_tests,
        ]);
    }


    public function select_test_type(Request $request, $subjectId)
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) {
            return $user;
        }
        
        // Yangi test tanlashdan oldin barcha oldingi test ma'lumotlarini tozalash
        session()->forget(['test_id', 'chapter_questions', 'remaining_time', 'quizAnswers', 'new_test', 'subjectName', 'chapterName']);
        $answersKey = 'answers_' . auth()->id();
        session()->forget($answersKey);
        
        // Foydalanuvchi haqidagi ma'lumotlarni API dan olish
        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }

        $test_types_response=ApiService::getFromApiForUser('final-test/types');
        $test_types=data_get($test_types_response, 'data', []);

        $get_subject_response=ApiService::getFromApiForUser('test/subjects');
        $subject=data_get($get_subject_response, 'data', []);
        $subjectName=collect($subject)->firstWhere('id', $subjectId)['name'] ?? null;
        // dd($test_types);
        $testCategory = $request->get('testCategory', 0);
        // dd($testCategory);
        // API chaqirish
        $response_chapters = ApiService::getFromApiForUser("test/chapters/{$subjectId}/{$testCategory}");
        $chapters = data_get($response_chapters, 'data', []);
        // dd($chapters);

        $response_final_tests = ApiService::getFromApiForUser("final-test/available-tests/{$subjectId}/{$testCategory}");
        $final_tests = data_get($response_final_tests, 'data', []);
        
        // Foydalanuvchi tomonidan yuborilgan ma'lumotlarni olish
        $get_testType = $request->input('testType');
        $get_chapterId = $request->input('chapterId');
        $get_finalTestId = $request->input('finalTestId');
        $get_subjectId = $request->input('subjectId');
        $get_chapterName = collect($chapters)->firstWhere('id', $get_chapterId)['name'] ?? null;
        $get_subjectName = collect($subject)->firstWhere('id', $get_subjectId)['name'] ?? null;
        
        if ($get_testType === 'bolim' && $get_chapterId) {
        session()->put('current_chapter_id', $get_chapterId);
        session()->put('subjectName', $get_subjectName);
        session()->put('chapterName', $get_chapterName);
        return redirect()->route('user.test.questions', ['chapterId' => $get_chapterId, 'new' => 1]);
        }
        
        // "Yakuniy" test uchun logika
        if ($get_testType === 'yakuniy') {
            session()->put('current_final_test_id', $get_finalTestId);
            return redirect()->route('user.final.test.questions', ['finalTestId' => $get_finalTestId, 'subjectId' => $get_subjectId, 'new' => 1]);
        }
        
        return view('user.select-test-type', compact('userData', 'chapters', 'test_types', 'final_tests', 'subjectName', 'subjectId'));
    }

    public function test_questions(Request $request, $chapterId)
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) {
        return $user;
        }

        $chapterId = session('current_chapter_id');
        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }

        $isNewTest = $request->has('new');
        $questionsKey = 'chapter_questions_' . $chapterId . '_' . auth()->id();

        $chapter_questions_all_params = null;

        if ($isNewTest || !session()->has($questionsKey)) {
        $apiResponse = ApiService::postFromApiForUser('test/start/' . $chapterId);

        $test_id = data_get($apiResponse, 'data.test_id', []);
        $chapter_questions = data_get($apiResponse, 'data.questions', []);

        // dd($chapter_questions_all_params);

        $chapter_questions = array_slice($chapter_questions, 0, 10);
        session()->put('test_id', $test_id);
        session()->put($questionsKey, $chapter_questions);
        session()->forget(['remaining_time', 'answers_' . auth()->id()]);
        } else {
        $chapter_questions = session($questionsKey);
        }

        $test_id = session('test_id');
        //    dd('Test ID: ' . $test_id);
        $userId = auth()->id();
        $answersKey = 'answers_' . $userId;
        $userAnswers = session($answersKey, []);

        $time_limit = 1800;
        $remaining_time = session('remaining_time', $time_limit);

        session([
        'test_id' => $test_id,
        'remaining_time' => $remaining_time,
        ]);

        $subject_name = session()->get('subjectName');
        $chapter_name = session()->get('chapterName');

        return view('user.test-questions', compact(
        'userData',
        'chapter_questions',
        'chapter_questions_all_params',
        'subject_name',
        'chapter_name',
        'test_id',
        'userAnswers',
        'remaining_time',
        'isNewTest'
        ));
    }

    public function final_test_questions(Request $request, $finalTestId)
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) {
        return $user;
        }

        $finalTestId = session('current_final_test_id');
        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }

        $isNewTest = $request->has('new');
        $questionsKey = 'final_test_questions_' . $finalTestId . '_' . auth()->id();
        $apiResponse = ApiService::getFromApiForUser('final-test/start-test/' . $finalTestId);
        $all_final_test_params = data_get($apiResponse, 'data', []);
        //dd($all_final_test_params);
        // dd($all_final_test_params);
        if ($isNewTest || !session()->has($questionsKey)) {
        
        // dd($apiResponse);
        $student_final_test_id = data_get($apiResponse, 'data.student_final_test.student_final_test_id', []);
        $final_test_questions = data_get($apiResponse, 'data.questions', []);

        session()->put('student_final_test_id', $student_final_test_id);
        session()->put($questionsKey, $final_test_questions);
        session()->forget(['remaining_time', 'answers_' . auth()->id()]);
        } else {
        $final_test_questions = session($questionsKey);
        }

        $student_final_test_id = session('student_final_test_id');
        // dd('Test ID: ' . $test_id);
        $userId = auth()->id();
        $answersKey = 'answers_' . $userId;
        $userAnswers = session($answersKey, []);

        $time_limit = 2800;
        $remaining_time = session('remaining_time', $time_limit);

        session([
        'student_final_test_id' => $student_final_test_id,
        'remaining_time' => $remaining_time,
        ]);

        $subject_name = session()->get('subjectName');
        $chapter_name = session()->get('chapterName');

        return view('user.final-test-questions', compact(
        'userData',
        'final_test_questions',
        'all_final_test_params',
        'subject_name',
        'chapter_name',
        'student_final_test_id',
        'userAnswers',
        'remaining_time',
        'isNewTest'
        ));
    }



    public function submitTest(Request $request)
    {
        $validated = $request->validate([
        'test_id' => 'required|integer',
        'answers' => 'required|array|min:1',
        'answers.*.id' => 'required|integer',
        'answers.*.answer' => 'required|string',
        ]);

        $chapter_test_id=session('test_id');

        \Log::info('Submitted Test Payload:', $validated);

        try {
        $response = ApiService::postFromApiForUser('test/check', $validated);
        \Log::info('API Response:', [$response]);

        $apiResponse = $response;

        if (isset($apiResponse['message']) && isset($apiResponse['errors'])) {
        throw new \Exception($apiResponse['message'] . ' Details: ' . json_encode($apiResponse['errors']));
        }

        if (!isset($apiResponse['success']) || !$apiResponse['success']) {
        throw new \Exception('API muvaffaqiyatsiz: ' . json_encode($apiResponse));
        }

        return response()->json($apiResponse, 200);

        } catch (\Exception $e) {
        \Log::error('API Error:', ['error' => $e->getMessage(), 'payload' => $validated]);
        return response()->json([
        'success' => false,
        'message' => 'Xato: ' . $e->getMessage(),
        ], 500);
        }
    }


    public function submitFinalTest(Request $request)
    {
        $validated = $request->validate([
            'student_final_test_id' => 'required|integer', // ❌ exists yo'q — chunki jadval localda mavjud emas
            'answers' => 'required|array|min:1',
            'answers.*.id' => 'required|integer', // ❌ exists yo'q
            'answers.*.type' => 'required|string|in:choose_option,fill_gap,essay',
            'answers.*.answer' => 'required|string',
        ]);
    
        \Log::info('Yakuniy test uchun yuborilayotgan payload:', $validated);
    
        try {
            $response = ApiService::postFromApiForUser('final-test/finish-test', $validated);
            \Log::info('API javobi (yakuniy test):', [$response]);
    
            if (isset($response['message']) && isset($response['errors'])) {
                throw new \Exception($response['message'] . ' Details: ' . json_encode($response['errors']));
            }
    
            if (!isset($response['success']) || !$response['success']) {
                throw new \Exception('API muvaffaqiyatsiz: ' . json_encode($response));
            }
    
            return response()->json($response, 200);
    
        } catch (\Exception $e) {
            \Log::error('Yakuniy testni yuborishda xatolik:', [
                'error' => $e->getMessage(),
                'payload' => $validated
            ]);
    
            return response()->json([
                'success' => false,
                'message' => 'Xato: ' . $e->getMessage(),
            ], 500);
        }
    }

    
    public function test_results()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) {
        return $user;
        }

        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }

        $chapter_test_id=session('test_id');
        $chapter_result_response = ApiService::getFromApiForUser("test/chapter-test-history");
        $chapter_result_data = collect(data_get($chapter_result_response, 'data', []))->firstWhere('id', $chapter_test_id);
        // dd($chapter_result_data);
        return view('user.test-results', compact('userData', 'chapter_result_data'));
    }

    public function final_test_results()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) {
        return $user;
        }

        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }

        $final_test_id=session('student_final_test_id');
        $final_test_result_response = ApiService::getFromApiForUser("final-test/results");
        $final_test_result_data = collect(data_get($final_test_result_response, 'data', []))->firstWhere('id', $final_test_id);
        // dd($final_test_result_data);
        return view('user.final-test-results', compact('userData', 'final_test_result_data'));
    }

    public function logout(Request $request)
{
    session()->forget(['auth_token', 'user']);
    session()->invalidate();
    session()->regenerateToken();
    $request->session()->flush();
    return redirect()->route('index')->with('success', 'Siz tizimdan chiqdingiz.');
}

}
