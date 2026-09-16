<?php

namespace App\Http\Requests;

use App\Http\Requests\StoreInventarisRequest;

class UpdateInventarisRequest extends StoreInventarisRequest
{
    // Aturan validasi update identik dengan create,
    // sehingga cukup mewarisi StoreInventarisRequest.
    // Dipisah menjadi class sendiri agar mudah dikembangkan
    // jika suatu saat aturan create & update perlu dibedakan.
}
