<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create initial testimonials
        $testimonials = [
            [
                'name' => 'Raina Bhattacharjee',
                'designation' => 'Founder cum Director/ Marg Darshak',
                'message' => 'It may sound strange in the 21st century, and perhaps contrary to who and what I am, that I always silently romanticised the Indian Joint Family!!!.... In Prasthan Yatnam (PY) that great Indian Joint Family has materialised at a different level !!!...I would say it is a joint family with a difference... It is also the platform which has provided a solid ground for me to pursue my spiritual journey with the very best of ingredients under one roof. PY is truly my dream come true, for which I am deeply grateful to all its wonderful members...PY is very very close to my heart especially because it is a healthy mix of ALL shades of life and people…It is an integral part of my existence and I am incomplete without it...',
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'Adrika Barthakur',
                'designation' => 'PY Member',
                'message' => 'I joined Prasthan Yatnam almost two years back. It has been a huge part of my life since then, and has helped me transform into a better person in this course of time. Prasthan Yatnam has given me a new definition and perspective of life and its consequent terms. It undertook me to a journey of self-realisation. Under the guidance of Raina Jethai, I entered a new way of life. I got introduced to the journey of spirituality. Her Thursday Discourses cover each and every sphere of life, starting from knowledge for a 16-year-old to even a 60-year-old. She makes sure that each and every Prasthani could understand her discourses and add a new dimension in their life every time they attend a session. I am eternally grateful to be a part of this journey, and hope to continue in future years as well🙏🏻',
                'is_active' => true,
                'display_order' => 2,
            ],
        ];

        foreach ($testimonials as $testimonialData) {
            Testimonial::create($testimonialData);
        }
    }
}
