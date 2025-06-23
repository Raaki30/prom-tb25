<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function getQuote()
    {
    $quotes = [
        "I’m not afraid to fall, I’ve learned to fly through the pain. – Laufey",
        "You said forever, but forever came too soon. – Ed Sheeran",
        "We danced in the silence, hearts louder than the beat. – SZA",
        "Even in the dark, I see your light in me. – The Weeknd",
        "I left my fears in the rearview, chasing dreams in high gear. – Tate McRae",
        "You were the calm in my chaos, the song in my silence. – Gracie Abrams",
        "We were just kids with grown-up hearts. – Zach Bryan",
        "I wrote your name in the stars, hoping you'd look up. – Lady Gaga",
        "You held my hand like it was the last time. – Conan Gray",
        "I’m still learning how to say goodbye without breaking. – Sabrina Carpenter",
        "You’re the echo in my empty room. – Laufey",
        "We were fire and rain, but we danced anyway. – PinkPantheress",
        "I loved you in the quiet, where no one else could hear. – Jennie",
        "You left a melody in my memory. – Dean Lewis",
        "I’m not who I was, but I’m still yours in every verse. – Alex Warren",
        "We were a song that never made the radio. – Michael Clifford",
        "You smiled like the sun, even when it rained. – Doechii",
        "I found myself in the spaces you left behind. – Gigi Perez",
        "You were the chorus I kept coming back to. – Laufey",
        "We were a moment, but you felt like forever. – Rema",
        "I loved you in the pauses between the lyrics. – Selena Gomez",
        "You were the reason I rewrote my story. – Zach Bryan",
        "We were louder than the silence we left. – Ed Sheeran",
        "You said goodbye like it was just another line. – Sabrina Carpenter",
        "I still hum your name when the world gets quiet. – Lady Gaga",
        "You were the verse I never finished. – Conan Gray",
        "We were a love song with no bridge. – SZA",
        "You left your voice in my favorite song. – Laufey",
        "We were a harmony that never resolved. – The Weeknd",
        "You were the lyric I never understood, but always felt. – Jennie",
        "I still hear you in the static. – Gracie Abrams",
        "We were a playlist on repeat. – Tate McRae",
        "You were the beat that made my heart dance. – PinkPantheress",
        "Even silence sounds like you. – Dean Lewis",
        "You were the song I didn’t know I needed. – Alex Warren",
        "We were music before we were words. – Lady Gaga"
    ];
        

        $randomQuote = $quotes[array_rand($quotes)];

        return response()->json([
            'quote' => $randomQuote
        ]);
    }
}
