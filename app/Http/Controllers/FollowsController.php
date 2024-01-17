<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowsController extends Controller
{
    public function followUser(Request $request, $userId)
    {
        $followerId = auth()->user()->id;

        // Vérifier si l'utilisateur suit déjà l'autre utilisateur
        $exists = DB::table('follows')->where('follower_id', $followerId)->where('following_id', $userId)->exists();

        if ($exists) {
            // Si déjà suivi, on arrête de suivre
            DB::table('follows')->where('follower_id', $followerId)->where('following_id', $userId)->delete();
            return response()->json(['success' => true, 'unfollowed' => true]);
        } else {
            // Sinon, on commence à suivre
            DB::table('follows')->insert([
                'follower_id' => $followerId,
                'following_id' => $userId,
                'created_at' => now(),
            ]);
            return response()->json(['success' => true, 'followed' => true]);
        }
    }
}
