<?php

namespace Codeception\Module\Portrino\DatabaseTables;

/**
 * Interface Typo3
 * @package Codeception\Module\Portrino\DatabaseTables
 */
interface Typo3
{
    const BACKEND_LAYOUT = 'backend_layout';

    const BE_SESSIONS = 'be_sessions';
    const BE_USERS = 'be_users';

    const FE_GROUPS = 'fe_groups';
    const FE_USERS = 'fe_users';
    const FE_SESSION_DATA = 'fe_session_data';

    const PAGES = 'pages';
    const PAGES_LANGUAGE_OVERLAY = 'pages_language_overlay';

    const SYS_CATEGORY_RECORD_MM = 'sys_category_record_mm';
    const SYS_COLLECTION_ENTRIES = 'sys_collection_entries';
    const SYS_FILE_METADATA = 'sys_file_metadata';
    const SYS_LOCKEDRECORDS = 'sys_lockedrecords';
    const SYS_LANGUAGE = 'sys_language';
    const SYS_FILE = 'sys_file';
    const SYS_FILE_COLLECTION = 'sys_file_collection';
    const SYS_LOG = 'sys_log';
    const SYS_FILEMOUNTS = 'sys_filemounts';
    const SYS_FILE_REFERENCE = 'sys_file_reference';
    const SYS_COLLECTION = 'sys_collection';
    const SYS_CATEGORY = 'sys_category';
    const SYS_FILE_PROCESSEDFILE = 'sys_file_processedfile';
    const SYS_HISTORY = 'sys_history';
    const SYS_FILE_STORAGE = 'sys_file_storage';
    const SYS_REGISTRY = 'sys_registry';
    const SYS_REFINDEX = 'sys_refindex';
    const SYS_TEMPLATE = 'sys_template';

    const TT_CONTENT = 'tt_content';

    const TX_SCHEDULER_TASK = 'tx_scheduler_task';
    const TX_SCHEDULER_TASK_GROUP = 'tx_scheduler_task_group';
}
