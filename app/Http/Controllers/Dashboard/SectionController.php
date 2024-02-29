<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repository\SectionRepositoryInterface;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    protected $Section;

    public function __construct(SectionRepositoryInterface $Section)
    {
        $this->Section = $Section;
    }

    public function index()
    {
        return $this->Section->index();
    }

    
    public function store(Request $r)
    {
        return $this->Section->store($r);
    }

    public function update(Request $request)
    {
        return $this->Section->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->Section->destroy($request);

    }
}
