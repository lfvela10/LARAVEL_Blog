<?php

namespace App\Http\Controllers;

use App\Project;
//use App\Mail\ProjectCreated;
//use Illuminate\Support\Facades\Mail;
use App\Events\ProjectCreated; //

class ProjectsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');

    }
    public function index()
    {
      //$projects = auth()->user()->projects;

      return view('projects.index', [

        'projects' => auth()->user()->projects

      ]);
    }

    public function create()
    {
      return view ('projects.create');
    }

    public function show (Project $project)
    {
      $this->authorize('update', $project);
      /* Wildcard called $project fetches Project with ID,
         with route model binding, laravel puts 2 and 2
         together. It knows to look in Projects for the ID
         that comes with $projects. This can be configured to
         what is in the URL bar as well. Called a slug?  */


      return view('projects.show', compact('project'));

    }

    /* Find or fail is an try catch that sends out a 404 form if an ID isnt
       present in the DB. Leaving this without route model binding just to
       remind myself */
    public function edit ($id)
    {
      $project = Project::findOrFail($id);
      return view('projects.edit', compact('project'));

    }

    public function update(Project $project)
    {
      $attributes = request()->validate([
      'title' => ['required', 'min: 3'],
      'description' => ['required', 'min: 3']

    ]);
       // this is the same as commented section
       $project->update(request(['title', 'description']));

       /*
         Code stored for reference only.
         //finds the project by its id
         $project = Project::findOrFail($id);

         // sets existing title to updated title
         $project->title = request('title');

         //sets exisiting description to updated description
         $project->description = request('description');

         //stores changes made
         $project->save();

       */

       return redirect('/projects');

    }

    public function destroy (Project $project)
    {
       $this->authorize('update', $project);
       $project->delete();

       return redirect('/projects');

    }

    /* The code below will give a MassAssignmentException. This is taken
       care of in Project.php */

    public function store()
    {
      /* This protects from use disabling required in html. If validation
         fails, were redirected back to previous page and sends through
         validation errors. Can be accessed through variable. */

        $project = Project::create(request()->validate([
        'title' => ['required', 'min: 3'],
        'description' => 'required'

        ]) + ['owner_id' => auth()->id()]);

        /* Unused code that is reduced. Saved for reference.
        $project = new Project ();
        $project->title = request('title');
        $project->description = request('description');
        $project->save(); */

        event(new ProjectCreated($project)); //

        /*// Mail

        \Mail::to($project->owner->email)->send(
              new ProjectCreated($project)
          ); */

      /* The double arrow operator, =>, is used as an access mechanism for
         arrays. This means that what is on the left side of it will have a
         corresponding value of what is on the right side of it in array
         context.

         The object operator, ->, is used in object scope to access methods
         and properties of an object. It’s meaning is to say that what is on
         the right of the operator is a member of the object instantiated into
         the variable on the left side of the operator. Instantiated is the
         key term here. */

      return redirect('/projects');
    }




}
