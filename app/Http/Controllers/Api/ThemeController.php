<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Theme;
use App\Http\Resources\ThemeResource;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::all();
        return ThemeResource::collection($themes);
    }

    public function store(Request $request)
    {
        $theme = $request->validate([
                'nom_theme' => 'required | string'
        ]);

        $ntheme = Theme::create([
            'nom_theme' => $theme['nom_theme']
        ]);

        return new ThemeResource($ntheme);
    }

    public function update(Request $request,$theme)
    {
        $themeEnQuestion = Theme::findOrFail($theme);

        $themeCorrige = $request->validate([
            'nom_theme' => 'required | string'
        ]);

        $themeEnQuestion->update([
            'nom_theme' => $themeCorrige['nom_theme']
        ]);

        return new ThemeResource($themeEnQuestion);
    }

    public function destroy($theme)
    {
        $themeEnQuestion = Theme::findOrFail($theme);
        $themeEnQuestion->delete();
        return response()->json([
            'message' => 'Theme supprimé avec succès',
            'code' => 400
        ]);
    }

    

}
