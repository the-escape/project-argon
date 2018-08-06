<?php

namespace Escape\Argon\EntityManagement\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Helpers\BlocksLibrary;
use Illuminate\Http\Request;
use Validator;
use Input;
use Lang;
use Redirect;
use View;
use DB;

class BlocksLibraryController extends BaseController
{
    protected $typeRepository;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:login');
        $this->middleware('perm:cms:content:manage');
        $this->middleware('perm:cms:entity:type:manage');
        $this->middleware('perm:cms:entity:type:create');
        $this->middleware('perm:cms:entity:type:edit');

        parent::__construct($request);
    }


    public function getBlock($blockId, BlocksLibrary $blocksLibrary)
    {
        $block = $blocksLibrary->getBlock($blockId);

        return response()->json($block);
    }


    public function createBlock(Request $request, BlocksLibrary $blocksLibrary)
    {
        $result = $blocksLibrary->createBlock($request);

        return response()->json($result);
    }


    public function updateBlock($blockId, Request $request, BlocksLibrary $blocksLibrary)
    {
        $result = $blocksLibrary->updateBlock($blockId, $request);

        return response()->json([
            'success' => $result
        ]);
    }

    public function deleteBlock($blockId, BlocksLibrary $blocksLibrary)
    {
        $result = $blocksLibrary->deleteBlock($blockId);

        return response()->json([
            'success' => $result
        ]);
    }

}