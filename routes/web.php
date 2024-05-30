<?php
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
class Task
{
  public function __construct(
    public int $id,
    public string $title,
    public string $description,
    public string $long_description,
    public bool $completed,
    public string $created_at,
    public string $updated_at
  ) {
  }
}

$tasks = [
  new Task(
    1,
    'Buy groceries',
    'Task 1 description',
    'Task 1 long description',
    false,
    '2023-03-01 12:00:00',
    '2023-03-01 12:00:00'
  ),
  new Task(
    2,
    'Sell old stuff',
    'Task 2 description',
    'Task 2 long description',
    false,
    '2023-03-02 12:00:00',
    '2023-03-02 12:00:00'
  ),
  new Task(
    3,
    'Learn programming',
    'Task 3 description',
    'Task 3 long description',
    true,
    '2023-03-03 12:00:00',
    '2023-03-03 12:00:00'
  ),
  new Task(
    4,
    'Take dogs for a walk',
    'Task 4 description',
    'Task 4 long description',
    false,
    '2023-03-04 12:00:00',
    '2023-03-04 12:00:00'
  ),
];
*/
//redirectare catre /tasks
Route::get('/', function() {
    return redirect()->route('tasks.index');
});

//fara DB, doar cu array; toate taskurile
//Route::get('/tasks', function () use ($tasks) {
 //   return view('index', ['tasks'=>$tasks]);
//})->name('tasks.index');

//cate un singur task pe baza id
// Varianta 1
//Route::get('/tasks/{id}', function ($id) use ($tasks){
    //return 'One single task';
    //return view('show', ['tasks'=>$tasks, 'id'=>$id]);
//})->name('tasks.show');
// Varianta 2
//Route::get('/tasks/{id}', function ($id) use ($tasks){
    // cu array
    //$task = collect($tasks)->firstWhere('id', $id);

    //if (!$task) {
    //    abort(Response::HTTP_NOT_FOUND);
    //}

    //cu DB

    //return view('show', ['task'=>$task]);

//})->name('tasks.show');

// CU DB
Route::get('/tasks', function () {
    return view('index', ['tasks'=>Task::latest()->paginate(10)]); //toate taskurile
})->name('tasks.index');

Route::view('/tasks/create', 'create')->name('tasks.create'); //add new task

Route::get('/tasks/{task}/edit', function (Task $task){
    return view('edit', ['task'=>$task]);
})->name('tasks.edit');

Route::get('/tasks/{task}', function (Task $task){
       return view('show', ['task'=>$task]); //detalii despre fiecare task pe baza id
})->name('tasks.show');

Route::post('/tasks', function (TaskRequest $request) {
    //dd($request->all());

        //$data = $request->validated();
        //$task = new Task;
       // $task->title = $data['title'];//preluam valorile din formular
        //$task->description = $data['description'];
        //$task->long_description = $data['long_description'];

        //$task->save(); //inserare task nou in DB
        $task = Task::create($request->validated());
        //return redirect()->route('tasks.show', ['id' => $task->id]);

        return redirect()->route('tasks.index')->with('success', 'Task added successfully');

})->name('tasks.store');

Route::put('/tasks/{task}', function (Task $task, TaskRequest $request) {
    //dd($request->all());

    //$data = $request->validated();
        //$task = Task::findOrFail($id);
        //$task->title = $data['title'];//preluam valorile din formular
        //$task->description = $data['description'];
        //$task->long_description = $data['long_description'];

        //$task->save(); //inserare task nou in DB
        $task->update($request->validated());
        //return redirect()->route('tasks.show', ['id' => $task->id]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');

})->name('tasks.update');

Route::delete('/tasks/{task}', function (Task $task) {
    $task->delete();

    return redirect()->route('tasks.index')
        ->with('success', 'Task deleted successfully!');
})->name('tasks.destroy');

//schimbam statusul taskului complet sau incomplet; 0 to 1; 1 to 0
Route::put('tasks/{task}/toggle-complete', function (Task $task) {
    $task->toggleComplete();
    return redirect()->back()->with('success', 'Task updated successfully!');
})->name('tasks.toggle-complete');


//trimitere catre blade
//Route::get('/', function () {
//    return view('index',['name'=>'Geo']);
//});

//pagina noua /hello; numele routei este hello
Route::get('/hello', function () {
return "hello";
})->name('helloroute');

// cu parametru: /greet/John
Route::get('/greet/{name}', function($name){
    return "Hello ".$name." !";
});

//in caz ca apelam o cale care nu exista
Route::fallback(function () {
    return 'the page do not exist!';
});
