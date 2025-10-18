<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewerController extends Controller
{
    /**
     * Display the specified submission for review.
     */
    public function showSubmission(Submission $submission)
    {
        // Security Check: A reviewer can only see submissions assigned to them.
        if ($submission->reviewer_id !== Auth::id()) {
            abort(403, 'This submission is not assigned to you.');
        }
        return view('reviewer.submissions.show', compact('submission'));
    }

    /**
     * Store feedback for a submission and update its status.
     */
    public function storeFeedback(Request $request, Submission $submission)
    {
        // Security Check: Ensure the correct reviewer is submitting feedback.
        if ($submission->reviewer_id !== Auth::id()) {
            abort(403, 'This submission is not assigned to you.');
        }

        // --- THE FIX IS HERE: More specific validation messages ---
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:20',
            'status' => 'required|string|in:Shortlisted,Rejected',
        ], [
            // Custom messages to make debugging easier
            'rating.required' => 'Please select a rating from 1 to 5.',
            'comment.required' => 'A feedback comment is required.',
            'comment.min' => 'The feedback comment must be at least 20 characters.',
            'status.required' => 'Please make a final decision (Shortlist or Reject).',
        ]);

        // Create the feedback record associated with the submission
        $submission->feedback()->create([
            'user_id' => Auth::id(), // The reviewer's ID
            'comment' => $validated['comment'],
            'rating' => $validated['rating'],
        ]);

        // Update the submission status based on the reviewer's decision
        $submission->update(['status' => $validated['status']]);

        // Redirect the reviewer back to their main dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Feedback for "' . $submission->title . '" has been submitted successfully.');
    }
}