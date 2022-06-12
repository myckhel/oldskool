<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Models\User;
use App\Notifications\NotifyAnniversary;
use App\Notifications\NotifyUpcomingAnniversary;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use phpDocumentor\Reflection\Types\Null_;

class SendAnniversary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // todays bday
        $bdusers = User::where('email', '!=', NULL)
            ->where(
                fn ($q) => $q
                    ->whereMonth('dob', Carbon::now()->format('m'))
                    ->whereDay('dob', Carbon::now()->format('d'))
            )->get();

        // wed ann bday
        $wedusers = User::where('email', '!=', NULL)
            ->where(
                fn ($q) => $q
                    ->whereMonth('wedding_date', Carbon::now()->format('m'))
                    ->whereDay('wedding_date', Carbon::now()->format('d'))
            )->get();

        $bdusers->map(fn ($user) => $user->notify(new NotifyAnniversary()));
        $wedusers->map(fn ($user) => $user->notify(new NotifyAnniversary('wedding')));

        $users = $wedusers->merge($bdusers);

        sizeof($users) && Admin::get()->map(fn ($admin) => $admin->notify(new NotifyUpcomingAnniversary($users)));
    }
}
