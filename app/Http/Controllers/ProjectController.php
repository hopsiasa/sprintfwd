<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use JsonException;

class ProjectController extends Controller
{
    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        try {
            $response = $this->projectService->getProjects();
            $projectsObject = json_decode($response->content(), false, 512, JSON_THROW_ON_ERROR);
            $projects = $projectsObject->projects;

            return view('projects.index', compact('projects'));
        } catch (JsonException $e) {
            return view('projects.index')->withErrors(['An error occurred while fetching projects.']);
        }
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $response = $this->projectService->newProject($request);
            $project = json_decode($response->content(), false, 512, JSON_THROW_ON_ERROR);

            return redirect()->route('projects.index')->with('success', $project->message);
        } catch (JsonException $e) {
            return redirect()->route('projects.index')->withErrors(['An error occurred while creating a new project.']);
        }
    }

    public function show($id)
    {
        try {
            $response = $this->projectService->showProject($id);
            $projectObject = json_decode($response->content(), false, 512, JSON_THROW_ON_ERROR);
            $project = $projectObject->project;

            return view('projects.show', compact('project'));
        } catch (JsonException $e) {
            return view('projects.show')->withErrors(['An error occurred while fetching the project.']);
        }
    }

    public function edit($id)
    {
        try {
            $response = $this->projectService->showProject($id);
            $projectObject = json_decode($response->content(), false, 512, JSON_THROW_ON_ERROR);
            $project = $projectObject->project;

            return view('projects.edit', compact('project'));
        } catch (JsonException $e) {
            return view('projects.edit')->withErrors(['An error occurred while fetching the project.']);
        }
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $response = $this->projectService->updateProject($request, $id);
            $project = json_decode($response->content(), false, 512, JSON_THROW_ON_ERROR);

            return redirect()->route('projects.index')->with('success', $project->message);
        } catch (JsonException $e) {
            return redirect()->route('projects.index')->withErrors(['An error occurred while updating the project.']);
        }
    }

    public function destroy($id): ?RedirectResponse
    {
        try {
            $this->projectService->deleteProject($id);

            return redirect()->route('projects.index')->with('success', 'Member deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('projects.index')->withErrors(['An error occurred while deleting the project.']);
        }
    }
}
