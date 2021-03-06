<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\LabelsManager;
use App\Http\Requests\LabelRequests\LabelRequestValidator;
use App\Http\Requests\LabelRequests\UpdateRequestValidator;
use App\Models\Label;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LabelController extends Controller
{
    private LabelsManager $labelsManager;

    public function __construct(LabelsManager $labelsManager)
    {
        $this->labelsManager = $labelsManager;
        $this->authorizeResource(Label::class, 'label');
    }

    public function index(): View
    {
        return view('app.labels.show', $this->labelsManager->getLabels());
    }

    public function create(): View
    {
        return view('app.labels.create');
    }

    public function store(LabelRequestValidator $request): RedirectResponse
    {
        $this->labelsManager->saveLabel($request->inputData());
        flash(__('flash-messages.labelWasCreated'))->success();
        return redirect()->route('labels.index');
    }

    public function edit(Label $label): View
    {
        return view('app.labels.edit', compact('label'));
    }

    public function update(LabelRequestValidator $request, Label $label): RedirectResponse
    {
        $this->labelsManager->updateLabel($request->inputData(), $label);
        flash(__('flash-messages.labelWasUpdated'))->success();
        return redirect()->route('labels.index');
    }

    public function destroy(Label $label): RedirectResponse
    {
        if ($this->labelsManager->isAttached($label)) {
            flash(__('flash-messages.labelWasNotDeleted'))->error();
            return redirect()->route('labels.index');
        }

        $this->labelsManager->deleteLabel($label);
        flash(__('flash-messages.labelWasDeleted'))->success();
        return redirect()->route('labels.index');
    }
}
