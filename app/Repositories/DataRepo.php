<?php

namespace App\Repositories;

use App\Annual;
use App\Repositories\Quotation\AnnualRepository;
use App\Repositories\Quotation\AuditingRepository;
use App\Repositories\Quotation\ConsultingRepository;
use App\Repositories\Quotation\AccountingServiceRepository;
use App\Repositories\Quotation\TaxationRepository;

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

    public static function quotation(): QuotationRepository
    {
        return app(QuotationRepository::class);
    }

    public static function accounting_service(): AccountingServiceRepository
    {
        return app(AccountingServiceRepository::class);
    }

    public static function auditing(): AuditingRepository
    {
        return app(AuditingRepository::class);
    }


    public static function consulting(): ConsultingRepository
    {
        return app(ConsultingRepository::class);
    }

    public static function taxation(): TaxationRepository
    {
        return app(TaxationRepository::class);
    }

    public static function invoice(): InvoiceRepository
    {
        return app(InvoiceRepository::class);
    }

}
