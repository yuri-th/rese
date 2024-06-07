<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderEmail;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;


class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reservation-email';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reservation reminder emails to users on the day of their reservation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');
        $reservations = Reservation::whereDate('date', $today)->get();

        foreach ($reservations as $reservation) {
            $user = User::with('reservations')->find($reservation->user_id);
            if ($user) {
            Mail::to($user->email)->send(new ReminderEmail($user, $reservation));
            }
        }
        $this->info('Reservation reminder emails sent successfully.');
    }
    }






