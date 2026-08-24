<?php

namespace Database\Factories;

use App\Models\Enquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enquiry>
 */
class EnquiryFactory extends Factory
{
    protected $model = Enquiry::class;

    public function definition(): array
    {
        return [
            'name' => 'Jane Guest',
            'email' => 'jane@example.com',
            'phone' => '+94771234567',
            'type' => Enquiry::TYPE_ROOM,
            'message' => 'I would like to stay for two nights.',
            'details' => [],
            'status' => Enquiry::STATUS_NEW,
        ];
    }
}
