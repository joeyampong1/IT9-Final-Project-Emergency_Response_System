<?php

namespace App\Mail;

use App\Models\Report;
use App\Models\Station;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StationAlert extends Mailable
{
    use Queueable, SerializesModels;

    public Report $report;
    public Station $station;

    /**
     * Create a new message instance.
     *
     * @param Report $report
     * @param Station $station
     */
    public function __construct(Report $report, Station $station)
    {
        $this->report = $report;
        $this->station = $station;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Determine subject based on report type
        $subject = match ($this->report->type) {
            'fire'     => '🔥 FIRE EMERGENCY – Immediate Response Required',
            'accident' => '🚑 MEDICAL EMERGENCY – Ambulance Needed',
            'crime'    => '🚨 CRIME ALERT – Police Assistance Required',
            default    => 'Emergency Alert – New Report Assigned',
        };

        return $this->subject($subject)
                    ->view('emails.station_alert')
                    ->with([
                        'report'  => $this->report,
                        'station' => $this->station,
                    ]);
    }
}