<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class StudentsSheet implements FromCollection, WithHeadings, WithTitle

{
    protected $planId;
    protected $students;

    // Constructor to accept the plan_id and students for that plan
    public function __construct($planId, $students)
    {
        $this->planId = $planId;
        $this->students = $students;
    }

    // Return the collection of students for this plan_id
    public function collection()
    {
        return $this->students;
    }

    // Set the headings for each sheet
    public function headings(): array
    {
        return [
            'ID',
            'Name Khmer',
            'Name English',
            'Gender',
            'Level',
            'Cadre',
            'Major',
            'Province',
            'Plan',
            'Register Date',
            // Add any other fields you'd like to export
        ];
    }

    // Set the title of the worksheet (plan name)
    public function title(): string
    {
        // Get the plan name based on plan_id
        $plan = \App\Models\Plan::find($this->planId);
        return $plan ? $plan->name_kh : 'Unknown Plan';
    }
}
