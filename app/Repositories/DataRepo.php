<?php

namespace App\Repositories;

class DataRepo
{
    public static function group_chat(): GroupChatRepository
    {
        return app(GroupChatRepository::class);
    }

    public static function user(): UserRepository
    {
        return app(UserRepository::class);
    }

    public static function customer(): CustomerRepository
    {
        return app(CustomerRepository::class);
    }

    public static function business(): BusinessRepostitory
    {
        return app(BusinessRepostitory::class);
    }

    public static function job_entry(): JobEntryRepository
    {
        return app(JobEntryRepository::class);
    }

    public static function pnl_excel(): PnlExcelRepository
    {
        return app(PnlExcelRepository::class);
    }

    public static function balance_sheet_excel(): BalanceSheetExcelRepository
    {
        return app(BalanceSheetExcelRepository::class);
    }
}
