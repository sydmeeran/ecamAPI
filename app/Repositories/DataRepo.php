<?php

namespace App\Repositories;

use App\Repositories\BalanceSheetExcel\Amount1Repository;
use App\Repositories\BalanceSheetExcel\Amount2Repository;
use App\Repositories\PnlExcel\CreditRepository;
use App\Repositories\PnlExcel\DebitRepository;
use App\Repositories\PnlExcel\VariationRepository;
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

    public static function role(): RoleRepository
    {
        return app(RoleRepository::class);
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

    // Pnl Excel
    public static function pnl_excel(): PnlExcelRepository
    {
        return app(PnlExcelRepository::class);
    }

    public static function pnl_debit(): DebitRepository
    {
        return app(DebitRepository::class);
    }

    public static function pnl_credit(): CreditRepository
    {
        return app(CreditRepository::class);
    }

    public static function pnl_variation(): VariationRepository
    {
        return app(VariationRepository::class);
    }

    // Balance Sheet
    public static function balance_sheet_excel(): BalanceSheetExcelRepository
    {
        return app(BalanceSheetExcelRepository::class);
    }

    public static function balance_sheet_amount_1(): Amount1Repository
    {
        return app(Amount1Repository::class);
    }

    public static function balance_sheet_amount_2(): Amount2Repository
    {
        return app(Amount2Repository::class);
    }

    public static function balance_sheet_variation(): \App\Repositories\BalanceSheetExcel\VariationRepository
    {
        return app(\App\Repositories\BalanceSheetExcel\VariationRepository::class);
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

    public static function receipt(): ReceiptRepository
    {
        return app(ReceiptRepository::class);
    }

    public static function schedule(): ScheduleRepository
    {
        return app(ScheduleRepository::class);
    }

}
