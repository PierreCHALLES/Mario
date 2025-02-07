<?php

namespace App\Http\Controllers;
use App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class TopRentalsController extends Controller
{

public function index()
{
 $sql = "
SELECT film.title, COUNT(rental.rental_id) AS total_rentals
FROM rental
INNER JOIN inventory ON rental.inventory_id = inventory.inventory_id
INNER JOIN film ON inventory.film_id = film.film_id
GROUP BY film.title
ORDER BY total_rentals DESC
LIMIT 10;

";

$topRentals = DB::select($sql);

return view ('top-rentals', ['topRentals' => $topRentals]);
}
}
