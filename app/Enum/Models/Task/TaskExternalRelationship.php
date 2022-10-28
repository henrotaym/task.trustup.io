<?php
namespace App\Enum\Models\Task;

/**
 * Representing task relationships.
 */
enum TaskExternalRelationship: string
{
    case USERS = "users";
}