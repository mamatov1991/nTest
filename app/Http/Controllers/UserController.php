<?php

namespace App\Http\Controllers;
use App\Domains\Api\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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
        $respMyTariffs = ApiService::getFromApiForUser('profile/my-tariffs');
        $my_tariffs    = $respMyTariffs['data'] ?? [];
        $final_test_result_response = ApiService::getFromApiForUser("final-test/results");
        $final_test_result_data = collect(data_get($final_test_result_response, 'data', []));
        $scoresByVariant = [];
        foreach ($final_test_result_data as $test) {
        $variantName = data_get($test, 'final_test.name', 'Noma\'lum variant');
        $score = data_get($test, 'score');  // null bo'lsa, qo'shilmaydi
        if ($score !== null) {
        if (!isset($scoresByVariant[$variantName])) {
        $scoresByVariant[$variantName] = [];
        }
        $scoresByVariant[$variantName][] = (int)$score;  // Int ga aylantirish
        }
        }
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }
        return view('user.index', compact('userData', 'final_test_result_data', 'scoresByVariant', 'my_tariffs'));
    }

    public function data()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;
        $respMyTariffs = ApiService::getFromApiForUser('profile/my-tariffs');
        $my_tariffs    = $respMyTariffs['data'] ?? [];
        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }
        return view('user.data', compact('userData', 'my_tariffs'));
    }

    public function results()
{
    $user = $this->requireUserOrRedirect();
    if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;
    $respMyTariffs = ApiService::getFromApiForUser('profile/my-tariffs');
    $my_tariffs    = $respMyTariffs['data'] ?? [];
    $response = ApiService::getFromApiForUser('profile/me');
    $userData = data_get($response, 'data', []);
    if (!$userData) {
        return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
    }
    $all = collect(data_get($final_test_result_response = ApiService::getFromApiForUser("final-test/results"), 'data', []))->sortByDesc('id')->values();

    $perPage = 10;
    $page = Paginator::resolveCurrentPage() ?: 1;

    $items = $all->slice(($page - 1) * $perPage, $perPage)->values();

    $final_test_result_data = new LengthAwarePaginator(
        $items,
        $all->count(),
        $perPage,
        $page,
        [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]
    );

    $final_test_result_data->appends(request()->query());

    return view('user.results', compact('userData', 'final_test_result_data', 'my_tariffs'));
}

    public function ranking()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        $subjects = collect(data_get($userData, 'subjects', []))->pluck('id')->all();
        $rankingData = [];
        foreach ($subjects as $subjectId) {
        $rankingResponse = ApiService::getFromApiForUser('profile/my-rating/' . $subjectId);
        $rankingData[$subjectId] = data_get($rankingResponse, 'data', []);
        }
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }
        $respMyTariffs = ApiService::getFromApiForUser('profile/my-tariffs');
        $my_tariffs    = $respMyTariffs['data'] ?? [];
        return view('user.ranking', compact('userData', 'my_tariffs', 'rankingData'));
    }

    public function invoice()
{
    $user = $this->requireUserOrRedirect();
    if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;
    $response = ApiService::getFromApiForUser('profile/me');
    $userData = data_get($response, 'data', []);
    if (!$userData) {
        return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
    }

    $respTariffs = ApiService::getFromApi('site/tariffs');
    $tariffs     = $respTariffs['data'] ?? [];

    $respMyTariffs = ApiService::getFromApiForUser('profile/my-tariffs');
    $my_tariffs    = $respMyTariffs['data'] ?? [];

    return view('user.invoice', compact('userData', 'tariffs', 'my_tariffs'));
}

    public function buy_tariff($tariffId)
{
    $user = $this->requireUserOrRedirect();
    if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

    $response = ApiService::getFromApiForUser('profile/me');
    $userData = data_get($response, 'data', []);

    if (!$userData) {
        return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
    }
    // $token = session('auth_token');
    // dd($token);
    $resBuyTariff = ApiService::postFromApiForUser('profile/buy-tariff/'.$tariffId);
    $buy_tariff = $resBuyTariff['data'] ?? [];
    
    if (!empty($buy_tariff['payment_link'])) {
        return redirect()->away($buy_tariff['payment_link']); 
    }

    return back()->with('error', 'To‘lov havolasi yaratilmagan.');
}



   public function setting()
{
    $user = $this->requireUserOrRedirect();
    if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

    $response = ApiService::getFromApiForUser('profile/me');
    $userData = data_get($response, 'data', []);
    if (!$userData) {
        return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
    }

    $regionsResp  = ApiService::getFromApiForUser('school/regions');
    $regions      = data_get($regionsResp, 'data', []);

    $districts    = [];
    if (!empty($userData['region']['id'])) {
        $districtsResp = ApiService::getFromApiForUser('school/districts/'.$userData['region']['id']);
        $districts     = data_get($districtsResp, 'data', []);
    }

    $schools = [];
    if (!empty($userData['district']['id'])) {
        $schoolsResp = ApiService::getFromApiForUser('school/schools/'.$userData['district']['id']);
        $schools     = data_get($schoolsResp, 'data', []);
    }

    $subjectsResp = ApiService::getFromApiForUser('school/subjects');
    $subjects     = data_get($subjectsResp, 'data', []);

    $respMyTariffs = ApiService::getFromApiForUser('profile/my-tariffs');
    $my_tariffs    = $respMyTariffs['data'] ?? [];

    return view('user.setting', compact('userData','regions','districts','schools','subjects', 'my_tariffs'));
}

    public function setting_post(Request $request)
{
    $user = $this->requireUserOrRedirect();
    if ($user instanceof \Illuminate\Http\RedirectResponse) return $user;

    $data = $request->validate([
        'name'         => ['required','string','max:255'],
        'surname'      => ['required','string','max:255'],
        'region_id'    => ['required','integer'],
        'district_id'  => ['required','integer'],
        'school_id'    => ['required','integer'],
        'class_number' => ['required','string','max:10'],
        'phone'        => ['nullable','string','max:20'], // <- o'zgardi
        'language'     => ['required','in:uz,ru,en'],
        'subjects'     => ['required','array'],
        'subjects.*'   => ['integer'],
    ]);

    try {
        $resp = ApiService::postFromApiForUser('profile/update', $data);
        if (($resp['success'] ?? false) === true) {
            return back()->with('success', 'Ma’lumotlar muvaffaqiyatli yangilandi.');
        }
        $msg = $resp['message'] ?? 'Yangilashda xatolik.';
        return back()->withInput()->withErrors(['api' => $msg])->with('error', $msg);

    } catch (\Throwable $e) {
        Log::error('profile update failed', ['e' => $e->getMessage()]);
        return back()->withInput()
            ->withErrors(['api' => 'Server bilan bog‘lanishda xatolik.'])
            ->with('error', 'Server bilan bog‘lanishda xatolik.');
    }
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
        $respMyTariffs = ApiService::getFromApiForUser('profile/my-tariffs');
        $my_tariffs    = $respMyTariffs['data'] ?? [];
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
        // dd($test_types);
        $test_duration=collect($test_types)->firstWhere('id', $subjectId)['duration'] ?? null;

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
        
       if(!empty($get_chapterId)){
        if ($get_testType === 'bolim' && $get_chapterId) {
        session()->put('current_chapter_id', $get_chapterId);
        session()->put('subjectName', $get_subjectName);
        session()->put('chapterName', $get_chapterName);
        return redirect()->route('user.test.questions', ['chapterId' => $get_chapterId, 'new' => 1]);
        }
       }        
        // "Yakuniy" test uchun logika
        if(!empty($get_finalTestId)){
        if ($get_testType === 'yakuniy') {
            session()->put('test_duration', $test_duration);
            session()->put('current_final_test_id', $get_finalTestId);
            return redirect()->route('user.final.test.questions', ['finalTestId' => $get_finalTestId, 'subjectId' => $get_subjectId, 'new' => 1]);
        }
        }
        
        return view('user.select-test-type', compact('userData', 'chapters', 'test_types', 'final_tests', 'subjectName', 'subjectId', 'my_tariffs'));
    }

    public function test_questions(Request $request, $chapterId)
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) {
        return $user;
        }
        $respMyTariffs = ApiService::getFromApiForUser('profile/my-tariffs');
        $my_tariffs    = $respMyTariffs['data'] ?? [];

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
        shuffle($chapter_questions);
        $chapter_questions = array_slice($chapter_questions, 0, 5);
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

        $time_limit = 600;
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
        'isNewTest',
        'my_tariffs'
        ));
    }

    public function final_test_questions(Request $request, $finalTestId)
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) {
        return $user;
        }
        $respMyTariffs = ApiService::getFromApiForUser('profile/my-tariffs');
        $my_tariffs    = $respMyTariffs['data'] ?? [];
// $token=session('auth_token');
// dd($token);
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
        $test_duration=session('test_duration');
        $time_limit = $test_duration*60;
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
        'isNewTest',
        'my_tariffs'
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
        $respMyTariffs = ApiService::getFromApiForUser('profile/my-tariffs');
        $my_tariffs    = $respMyTariffs['data'] ?? [];
        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }

        $chapter_test_id=session('test_id');
        $chapter_result_response = ApiService::getFromApiForUser("test/chapter-test-history");
        $chapter_result_data = collect(data_get($chapter_result_response, 'data', []))->firstWhere('id', $chapter_test_id);
        // dd($chapter_result_data);
        return view('user.test-results', compact('userData', 'chapter_result_data', 'my_tariffs'));
    }

    public function final_test_results()
    {
        $user = $this->requireUserOrRedirect();
        if ($user instanceof \Illuminate\Http\RedirectResponse) {
        return $user;
        }
        $respMyTariffs = ApiService::getFromApiForUser('profile/my-tariffs');
        $my_tariffs    = $respMyTariffs['data'] ?? [];
// $token = session('auth_token');
//         dd($token);
        $response = ApiService::getFromApiForUser('profile/me');
        $userData = data_get($response, 'data', []);
        if(!$userData) {
            return redirect()->route('user.logout')->with('error', 'Iltimos, avval tizimga kiring.');
        }

        $final_test_id=session('student_final_test_id');
        $final_test_result_response = ApiService::getFromApiForUser("final-test/results");
        $final_test_result_data = collect(data_get($final_test_result_response, 'data', []))->firstWhere('id', $final_test_id);
        // dd($final_test_result_data);
        return view('user.final-test-results', compact('userData', 'final_test_result_data', 'my_tariffs'));
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
