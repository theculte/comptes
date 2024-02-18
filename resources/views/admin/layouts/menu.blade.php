<li class="{{ Request::is('admin/operations*') ? 'active' : '' }}">
    <a href="{!! route('admin.operations.index') !!}">
    <i class="livicon" data-c="#31B0D5" data-hc="#31B0D5" data-name="list" data-size="18"
               data-loop="true"></i>
               Operations
    </a>
</li>

<li class="{{ Request::is('admin/types*') ? 'active' : '' }}">
    <a href="{!! route('admin.types.index') !!}">
    <i class="livicon" data-c="#31B0D5" data-hc="#31B0D5" data-name="list" data-size="18"
               data-loop="true"></i>
               Types
    </a>
</li>

<li class="{{ Request::is('admin/categories*') ? 'active' : '' }}">
    <a href="{!! route('admin.categories.index') !!}">
    <i class="livicon" data-c="#418BCA" data-hc="#418BCA" data-name="list" data-size="18"
               data-loop="true"></i>
               Categories
    </a>
</li>

<li class="{{ Request::is('admin/operationTypes*') ? 'active' : '' }}">
    <a href="{!! route('admin.operationTypes.index') !!}">
    <i class="livicon" data-c="#418BCA" data-hc="#418BCA" data-name="bank" data-size="18"
               data-loop="true"></i>
               OperationTypes
    </a>
</li>

<li class="{{ Request::is('admin/soldes*') ? 'active' : '' }}">
    <a href="{!! route('admin.soldes.index') !!}">
    <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="dashboard" data-size="18"
               data-loop="true"></i>
               Soldes
    </a>
</li>

<li class="{{ Request::is('admin/operationRecurents*') ? 'active' : '' }}">
    <a href="{!! route('admin.operationRecurents.index') !!}">
    <i class="livicon" data-c="#F89A14" data-hc="#F89A14" data-name="list" data-size="18"
               data-loop="true"></i>
               OperationRecurents
    </a>
</li>

<li class="{{ Request::is('admin/operationIncommings*') ? 'active' : '' }}">
    <a href="{!! route('admin.operationIncommings.index') !!}">
    <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="list" data-size="18"
               data-loop="true"></i>
               OperationIncommings
    </a>
</li>

<li class="{{ Request::is('admin/operationIncs*') ? 'active' : '' }}">
    <a href="{!! route('admin.operationIncs.index') !!}">
    <i class="livicon" data-c="#F89A14" data-hc="#F89A14" data-name="list" data-size="18"
               data-loop="true"></i>
               OperationIncs
    </a>
</li>

