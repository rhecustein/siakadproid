<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;

use App\Models\Conversation;
use App\Models\Document;
use App\Models\GeneratedDocument;
use App\Models\DataVisualization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class AiController extends Controller
{
    /**
     * Display the AI chat interface.
     */
    public function index(): View
    {
        $conversations = Auth::user()->conversations()->latest()->get();
        $documents = Auth::user()->documents()->latest()->get();
        $publicDocuments = Document::where('is_public', true)->latest()->get();
        return view('ai.index', compact('conversations', 'documents', 'publicDocuments'));
    }

    /**
     * Handle AI chat interactions.
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->input('message');
        $userId = Auth::id();

        // Here, you would integrate with your AI service (e.g., OpenAI, Gemini, etc.)
        // For now, a placeholder response:
        $aiResponse = "I received your message: '{$userMessage}'. I'm still learning how to provide comprehensive answers based on your data.";

        // Save conversation
        $conversation = Conversation::create([
            'user_id' => $userId,
            'user_message' => $userMessage,
            'ai_response' => $aiResponse,
        ]);

        return response()->json(['message' => $aiResponse]);
    }

    /**
     * Handle document uploads.
     */
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,txt|max:10240', // Max 10MB
            'is_public' => 'boolean',
            'description' => 'nullable|string|max:255',
        ]);

        $userId = Auth::id();
        $file = $request->file('document');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName, 'public'); // Store in storage/app/public/documents

        $document = Document::create([
            'user_id' => $userId,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_mime_type' => $file->getMimeType(),
            'is_public' => $request->boolean('is_public'),
            'description' => $request->input('description'),
        ]);

        return response()->json(['message' => 'Document uploaded successfully!', 'document' => $document]);
    }

    /**
     * Generate content (e.g., questions, summaries).
     */
    public function generateContent(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:question,summary,report',
            'prompt' => 'required|string',
            'conversation_id' => 'nullable|exists:conversations,id',
        ]);

        $userId = Auth::id();
        $prompt = $request->input('prompt');
        $type = $request->input('type');
        $conversationId = $request->input('conversation_id');

        // Logic to generate content based on the prompt and type, potentially using AI service
        // For demonstration, a simple placeholder:
        $generatedContent = "Generated {$type} based on: '{$prompt}'.";

        $document = GeneratedDocument::create([
            'user_id' => $userId,
            'type' => $type,
            'content' => $generatedContent,
            'conversation_id' => $conversationId,
        ]);

        return response()->json(['message' => 'Content generated successfully!', 'generated_document' => $document]);
    }

    /**
     * Generate data visualization.
     */
    public function generateVisualization(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:diagram,chart,statistic',
            'data_description' => 'required|string',
            'conversation_id' => 'nullable|exists:conversations,id',
        ]);

        $userId = Auth::id();
        $dataDescription = $request->input('data_description');
        $type = $request->input('type');
        $conversationId = $request->input('conversation_id');

        // In a real application, this would involve:
        // 1. Parsing dataDescription to understand what data to visualize.
        // 2. Fetching relevant data from your database (e.g., student grades, attendance).
        // 3. Using a charting library (e.g., Chart.js, D3.js) or an AI image generation service
        //    to create the visualization.
        // 4. Saving the generated image and its metadata.

        $imagePath = null;
        $mockData = ['example' => 'data']; // Replace with actual data extraction

        // Placeholder for image generation
        $mockImagePath = 'visualizations/mock_image_' . time() . '.png';
        Storage::disk('public')->put($mockImagePath, 'This is a mock image content for a ' . $type); // Create a dummy file

        $visualization = DataVisualization::create([
            'user_id' => $userId,
            'type' => $type,
            'data_source' => $mockData,
            'image_path' => $mockImagePath,
            'description' => "Visualization of {$dataDescription}",
            'conversation_id' => $conversationId,
        ]);

        return response()->json(['message' => 'Visualization generated successfully!', 'visualization' => $visualization]);
    }

    /**
     * Respond to questions based on database.
     * This method will need significant expansion to query actual database information.
     */
    public function queryDatabase(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'conversation_id' => 'nullable|exists:conversations,id',
        ]);

        $userId = Auth::id();
        $question = $request->input('question');
        $conversationId = $request->input('conversation_id');

        // Example: How to answer "nilai anak saya berapa?"
        $response = "I'm designed to respond to questions based on your database. For '{$question}', I would typically query student grades from the 'student_scores' or 'grades' tables and provide a summary. Please specify the student's name and academic period for a precise answer. This feature requires advanced natural language processing and database querying capabilities to be fully functional.";

        // In a real scenario, you'd parse the question, identify entities (student name, subject, academic year),
        // query the relevant models (e.g., Student, Grade, AcademicYear), and formulate a response.
        // Example (conceptual):
        /*
        if (str_contains(strtolower($question), 'nilai anak saya')) {
            $studentName = $this->extractStudentName($question); // Custom helper function
            $student = Student::where('name', 'like', '%' . $studentName . '%')->first();
            if ($student) {
                $grades = $student->grades()->whereHas('academicYear', function ($query) {
                    $query->where('is_current', true); // Assuming a current academic year
                })->get();
                $response = "Here are {$student->name}'s grades for the current academic year: " . $grades->pluck('score', 'subject')->toJson();
            } else {
                $response = "Could not find a student with that name.";
            }
        }
        */

        $conversation = Conversation::create([
            'user_id' => $userId,
            'user_message' => $question,
            'ai_response' => $response,
        ]);

        return response()->json(['message' => $response]);
    }

    // Additional methods for future features can be added here
    public function futureFeatureExample(Request $request)
    {
        // ... logic for a new feature ...
        return response()->json(['message' => 'This is a placeholder for a future AI feature.']);
    }
}