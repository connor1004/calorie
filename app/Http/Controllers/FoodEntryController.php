<?php

namespace App\Http\Controllers;

use App\Models\FoodEntry;
use Illuminate\Http\Request;
use App\Http\Requests\{
    FoodEntryStoreRequest,
    FoodEntryUpdateRequest
};
use Carbon\Carbon;

class FoodEntryController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(FoodEntry::class, 'food_entry');
    }

    /**
     * Display a listing of the food entries that the auth user took.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->user()->foodEntries()->orderBy('taken_at', 'DESC');

        if ($request->input('start', 0)) {
            $query->where('taken_at', '>=', $request->start);
        }
        if ($request->input('end', 0)) {
            $query->where('taken_at', '<', $request->end);
        }

        return [
            'data' => $query->get(),
        ];
    }

    /**
     * Display a listing of all food entries.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewAll(Request $request)
    {
        $this->authorize('viewAll', FoodEntry::class);

        $query = FoodEntry::with('takenUser')->orderBy('taken_at', 'DESC');

        if ($request->input('start', 0)) {
            $query->where('taken_at', '>=', $request->start);
        }
        if ($request->input('end', 0)) {
            $query->where('taken_at', '<', $request->end);
        }

        return [
            'data' => $query->get(),
        ];
    }

    /**
     * Store a newly created food entry in storage.
     *
     * @param  FoodEntryStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodEntryStoreRequest $request)
    {
        $entry = new FoodEntry;

        $entry->fill($request->all());
        $entry->taken_by = $request->taken_by;
        $entry->save();

        return [
            'data' => $entry->fresh(),
        ];
    }

    /**
     * Display the specified food entry.
     *
     * @param  \App\Models\FoodEntry  $foodEntry
     * @return \Illuminate\Http\Response
     */
    public function show(FoodEntry $foodEntry)
    {
        return [
            'data' => $foodEntry,
        ];
    }

    /**
     * Update the specified food entry in storage.
     *
     * @param  FoodEntryUpdateRequest  $request
     * @param  \App\Models\FoodEntry  $foodEntry
     * @return \Illuminate\Http\Response
     */
    public function update(FoodEntryUpdateRequest $request, FoodEntry $foodEntry)
    {
        $foodEntry->update($request->all());

        if ($request->user()->role == 'admin' && $request->input('taken_by', null)) {
            $foodEntry->taken_by = $request->taken_by;
            $foodEntry->save();
        }

        return [
            'data' => $foodEntry->fresh(),
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FoodEntry  $foodEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(FoodEntry $foodEntry)
    {
        $foodEntry->delete();
        return response(null, 204);
    }

    /**
     * Get calorie consumption for today and money spent this month
     */
    public function getUserStats(Request $request) {
        $user = $request->user();

        $timezone = $request->input('timezone', $user->timezone ? $user->timezone : 'UTC');

        $dayStart = Carbon::now()
            ->setTimezone($timezone)
            ->startOfDay()
            ->timestamp;

        $dayEnd = Carbon::now()
            ->setTimezone($timezone)
            ->addDay()
            ->startOfDay()
            ->timestamp;

        $monthStart = Carbon::now()
            ->setTimezone($timezone)
            ->startOfMonth()
            ->timestamp;

        $monthEnd = Carbon::now()
            ->setTimezone($timezone)
            ->addMonth()
            ->startOfMonth()
            ->timestamp;

        $dayCalorieConsumption = $user->foodEntries()
            ->where('taken_at', '>=', $dayStart)
            ->where('taken_at', '<', $dayEnd)
            ->sum('calorie');

        $spentMoney = $user->foodEntries()
            ->where('taken_at', '>=', $monthStart)
            ->where('taken_at', '<', $monthEnd)
            ->sum('price');

        return [
            'data' => [
                'calorie_consumption' => $dayCalorieConsumption,
                'money_spent' => $spentMoney,
            ],
        ];
    }

    /**
     * Get report for admin
     */
    public function getReport(Request $request) {
        if ($request->user()->role != 'admin') {
            return response([
                'message' => "This action is unauthorized."
            ], 403);
        }

        $currentTime = Carbon::now()->timestamp;
        $aWeekAgo = Carbon::now()->subDays(7)->timestamp;
        $twoWeekAgo = Carbon::now()->subDays(14)->timestamp;

        $last7Count = FoodEntry::where('taken_at', '>=', $aWeekAgo)
            ->where('taken_at', '<=', $currentTime)->count();

        $previous7Count = FoodEntry::where('taken_at', '>=', $twoWeekAgo)
            ->where('taken_at', '<=', $aWeekAgo)->count();

        $userCalories = FoodEntry::where('taken_at', '>=', $aWeekAgo)
            ->where('taken_at', '<=', $currentTime)
            ->select(\DB::raw('taken_by, sum(calorie) as calorie_sum'))
            ->groupBy('taken_by')
            ->get();

        $count = 0;
        $sum = 0;

        foreach ($userCalories as $calorie) {
            $count ++;
            $sum += $calorie->calorie_sum;
        }

        $average = $count == 0 ? 0 : $sum / $count;

        return [
            'data' => [
                'last_7_days_count' => $last7Count,
                'previous_7_days_count' => $previous7Count,
                'last_7_days_average' => $average,
            ],
        ];
    }
}
