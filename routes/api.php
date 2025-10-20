use App\Models\Prodi;
use Illuminate\Support\Facades\Route;

Route::get('/fakultas/{id}/prodi', function ($id) {
    return response()->json(Prodi::where('fakultas_id', $id)->get());
});
