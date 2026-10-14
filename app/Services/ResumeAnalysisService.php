<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;
use Spatie\PdfToText\Pdf;

class ResumeAnalysisService
{
    public function extractResumeInfromation(string $fileUrl)
    {
        try {
            // Extract raw text from Resume,read pdf and get text
            $rawText = $this->extractTextFromPdf($fileUrl);

            Log::debug('Successfully Extracted File'.strlen($rawText));
            // Use OpenAI-compatible API (Groq) to organize text into structured format
            $response = OpenAI::chat()->create([
                'model' => config('openai.model'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Extract information exactly as it appears in the resume without adding any interpretation or additional info. Respond only with valid JSON.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "Parse the following resume content and extract the information as a JSON object with exact keys: 'summary', 'skills', 'experience', 'education'. Return an empty string for any key that is not found. Resume content: {$rawText}",
                    ],
                ],
                'response_format' => [
                    'type' => 'json_object',
                ],
                'temperature' => 0,
            ]);
            $result = $response->choices[0]->message->content;
            Log::debug('OpenAI response'.$result);

            $parsedResult = json_decode($result, true);

            $requiredKeys = ['summary', 'skills', 'experience', 'education'];
            $missingKeys = array_diff($requiredKeys, array_keys($parsedResult));

            if (count($missingKeys) > 0) {

                Log::debug(''.count($missingKeys));
                throw new \Exception('Missing required keys');
            }

            // return json Object
            return [
                'summary' => $parsedResult['summary'] ?? '',
                'skills' => $parsedResult['skills'] ?? '',
                'experience' => $parsedResult['experience'] ?? '',
                'education' => $parsedResult['education'] ?? '',

            ];
        } catch (\Exception $e) {

            Log::error('Error extracting resume info'.$e->getMessage());

            return [
                'summary' => '',
                'skills' => '',
                'experience' => '',
                'education' => '',
            ];
        }
    }

    public function analyzeResume($jobVacancy, $resumeData)
    {
        try {
            $jobDetails = json_encode([
                'job_title' => $jobVacancy->title,
                'job_description' => $jobVacancy->description,
                'job_location' => $jobVacancy->location,
                'job_type' => $jobVacancy->type,
                'job_salary' => $jobVacancy->salary,
            ]);

            $resumeDetails = json_encode($resumeData);

            $response = OpenAI::chat()->create([
                'model' => config('openai.model'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are an expert HR professional and job recruiter. Analyze resumes and determine if the candidate is good for the job. Output valid JSON only, with the keys 'AI_Generated_score' and 'AI_Generated_feedback'. Provide a score from 0 to 100 for the candidate's suitability for the job and specific, detailed feedback.",
                    ],
                    [
                        'role' => 'user',
                        'content' => "Please evaluate this job application. Job Details: {$jobDetails}. Resume Details: {$resumeDetails}",
                    ],
                ],
                'response_format' => [
                    'type' => 'json_object',
                ],
                'temperature' => 0,
            ]);

            $result = $response->choices[0]->message->content;
            Log::debug('OpenAI Response'.$result);
            $parsedResult = json_decode($result, true);

            return [
                'AI_Generated_score' => $parsedResult['AI_Generated_score'] ?? '', 'AI_Generated_feedback' => $parsedResult['AI_Generated_feedback'] ?? '',
            ];
        } catch (\Exception $e) {
            return [
                'AI_Generated_score' => 0, 'AI_Generated_feedback' => 'An Error Occured While Analyzing Resume,try again later',
            ];
        }
    }

    private function extractTextFromPdf(string $fileUrl): string
    {

        // region File Streaming and file open From Cloud to local storage
        $tempFile = tempnam(sys_get_temp_dir(), 'resume');
        $filePath = parse_url($fileUrl, PHP_URL_PATH);

        if (! $filePath) {
            throw new \Exception('Invalid File Url');
        }

        $fileName = basename($filePath);

        $storagePath = "resumes/{$fileName}";

        if (! Storage::disk('local')->exists($storagePath)) {
            throw new \Exception('File not found');
        }

        $pdfContent = Storage::disk('local')->get($storagePath);

        if (! $pdfContent) {
            throw new \Exception('Failed to read file');
        }

        file_put_contents($tempFile, $pdfContent);

        // Check if pdf to text installed

        $pdfToTextPath = ['/usr/bin/pdftotext'];
        $pdfToTextAvailable = false;
        foreach ($pdfToTextPath as $path) {
            if (file_exists($path)) {
                $pdfToTextAvailable = true;
                break;
            }
        }

        if (! $pdfToTextAvailable) {
            throw new \Exception('pdf to text is not installed');
        }

        // endregion
        // Extracted Text
        $text = (new Pdf)->setPdf($tempFile)->text();

        unlink($tempFile);

        return $text;
    }
}
