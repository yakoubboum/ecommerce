<?php


namespace App\Repository;

use App\Models\Section;
use App\Repository\SectionRepositoryInterface;







class SectionRepository implements SectionRepositoryInterface
{

    public function index()
    {
        $Sections = Section::all();
        return \view('Dashboard.Sections.index', \compact('Sections'));
    }

    public function show($id)
    {
    }

    public function store($r)
    {

        Section::create([
            'name' => $r->name,
        ]);
        session()->flash('add');
        return back();
    }

    public function update($request)
    {
        $section = Section::findOrFail($request->id);
        $section->update([
            'name' => $request->input('name'),
        ]);
        session()->flash('edit');
        return redirect()->route('sections.index');
    }

    public function destroy($request)
    {
        Section::findOrFail($request->id)->delete();
        session()->flash('delete');
        return redirect()->route('sections.index');
    }
}
