<?php

namespace Escape\Argon\EntityManagement;

abstract class RevisionStatus
{
    const DRAFT = 1;
    const PUBLISHED = 2;
    const PREVIOUSLY_PUBLISHED = 3;
    const PREVIEW = 4;
}
