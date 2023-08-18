<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function list()
    {
        // récupération des tâches en base de données
        // en utilisant le modèle Eloquent (ORM)
        $tasks = Task::all();

        // retourne la liste des tâches au format json
        return response()->json($tasks);
    }

    // Retourne une tâche
    public function read($id)
    {
        // récupération de l'objet Task d'identifiant $id
        $task = Task::find($id);

        // si pas d'enregistrement en base : erreur 404
        // sinon retourne l'objet au format json
        if (!$task) {
            return response(null, 404);
        } else {
            return response()->json($task);
        }
    }

    // Création d'une nouvelle tâche
    public function create(Request $request)
    {
        // validation du champ title dans les données de la requête
        // le champ title dans la requête est obligatoire (required)
        // et non vide (filled = !empty())
        $validator = Validator::make($request->input(), [
            'title' => ['required', 'filled']
        ]);

        // s'il y a une ou des erreurs, on les retourne en json
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        // récupération du champ title depuis la requête
        $title = $request->input('title');

        $task = new Task();
        $task->title = $title;

        if ($task->save()) {
            return response()->json($task, 201); // code 201 : CREATED
        } else {
            return response(null, 500); // code 500 : Internal server error
        }
    }

    // Mise à jour d'une tâche
    public function update($id, Request $request)
    {
        // récupération et validation de l'objet à mettre à jour
        $task = Task::find($id);

        if (!$task) {
            return response(null, 404);
        }

        // validation des données
        $validator = Validator::make($request->input(), [
            'title' => ['required', 'filled'],
            'status' => ['required', 'filled'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // si tout est OK, on peut mettre à jour l'objet
        $title = $request->input('title');
        $status = $request->input('status');
        $task->title = $title;
        $task->status = $status;

        if ($task->save()) {
            return response()->json($task);
        } else {
            return response(null, 500); // code 500 : Internal server error
        }
    }

    // Suppression d'une tâche
    public function delete($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response(null, 404);
        }

        if ($task->delete()) {
            return response(null, 200);
        } else {
            return response(null, 500);
        }
    }
}
