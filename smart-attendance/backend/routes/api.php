use App\Models\Student;
use Illuminate\Http\Request;

Route::get('/students', function () {
    return Student::all();
});

Route::post('/students', function (Request $request) {
    return Student::create($request->all());
});
