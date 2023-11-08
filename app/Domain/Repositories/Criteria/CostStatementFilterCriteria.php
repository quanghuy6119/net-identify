<?php

namespace App\Domain\Repositories\Criteria;

use App\Domain\Constants\OrderDirection;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Repositories\Criteria\Criteria;
use Carbon\Carbon;

class CostStatementFilterCriteria extends Criteria
{
    private ?Carbon $paymentFrom = null;

    private ?Carbon $paymentTo = null;

    private ?string $paymentNo = null;

    private ?array $supplierIds = null;

    private ?array $projectIds = null;

    private string $order;

    private string $direction;

    private array $orderPropertyMap = [
        "paymentNo" => "payments.no",
        "paymentDate" => "payments.payment_date",
        "completedAt" => "payments.completed_at",
        "createdAt" => "payments.created_at",
        "updatedAt" => "payments.updated_at",
        "supplierNo" => "companies.code",
        "supplierName" => "companies.name"
    ];

    public function __construct(?string $paymentNo, ?Carbon $paymentFrom, ?Carbon $paymentTo, ?array $supplierIds, ?array $projectIds, string $order = "updatedAt", $direction = OrderDirection::ASC)
    {
        $this->paymentNo = $paymentNo;
        $this->paymentFrom = is_null($paymentFrom) ? null : $paymentFrom->utc();
        $this->paymentTo = is_null($paymentTo) ? null : $paymentTo->utc();
        $this->supplierIds = $supplierIds;
        $this->projectIds = $projectIds;
        $this->direction = $direction;
        $this->order = $this->orderPropertyMap[$order];
    }
    public function apply(Builder $query)
    {
        $query = $query->leftJoin('orders', 'orders.id', '=', 'payments.order_id');
        $this->applyPaymentNo($query);
        $this->applyFilterByProjects($query);
        $this->applyFilterBySuppliers($query);
        $this->applyPaymentDuration($query);
        $this->applyOrderBy($query);
        return $query->select('payments.*');
    }

    private function applyOrderBy(Builder $query):  Builder {
        if ($this->order == "companies.code" || $this->order == "companies.name") return $query->leftJoin('companies', 'payments.supplier_id', '=', 'companies.id')->orderBy($this->order, $this->direction);
        
        return $query->orderBy($this->order, $this->direction);
    }

    private function applyPaymentNo(Builder $query):  Builder{
        return is_null($this->paymentNo) ? $query : $query->where('payments.no', $this->paymentNo);
    }

    private function applyPaymentDuration(Builder $query):  Builder{
        $query = $this->canFilterByPaymentFrom() ? $query->where('payments.payment_date', '>=', $this->paymentFrom->toDateTimeString()) : $query;
        return $this->canFilterByPaymentTo() ? $query->where('payments.payment_date', '<=', $this->paymentTo->toDateTimeString()) : $query;
    }
    
    private function applyFilterBySuppliers(Builder $query):  Builder{
        if(!$this->canFilterBySuppliers()) return $query;
        $supplierIds = $this->supplierIds;
        return $query->where(function ($query) use ($supplierIds) {
            $query->whereIn('payments.supplier_id', $supplierIds)
                ->orWhereIn('orders.supplier_id', $supplierIds);
        });
    }

    private function applyFilterByProjects(Builder $query):  Builder{
        return $this->canFilterByProjects() ? $query->whereIn('orders.project_id', $this->projectIds) : $query;
    }

    private function canFilterByProjects(): bool
    {
        return !is_null($this->projectIds) && !empty($this->projectIds);
    }

    private function canFilterBySuppliers(): bool
    {
        return !is_null($this->supplierIds) && !empty($this->supplierIds);
    }

    private function canFilterByPaymentFrom(): bool
    {
        return !is_null($this->paymentFrom);
    }

    private function canFilterByPaymentTo(): bool
    {
        return !is_null($this->paymentTo);
    }
}