<?php

namespace Virrealy\Api\Repository\Table;

class StageTable
{
	const ID              = 'id';
	const TYPE            = 'type';
	const INFORMATION     = 'information';
	const ANSWER          = 'answer';
	const VALIDATION_TYPE = 'validation_type';

	const TYPE_PASSWORD          = 'PASSWORD';
	const TYPE_GPS               = 'GPS';
	const TYPE_PATH_FINDER       = 'PATH_FINDER';
	const TYPE_AUGMENTED_REALITY = 'AUGMENTED_REALITY';

	const VALIDATION_TYPE_TEXT = 'TEXT';
	const VALIDATION_TYPE_GPS  = 'GPS';
	const VALIDATION_TYPE_NO   = 'NO';
}