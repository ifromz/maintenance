<script type="text/template" data-grid="assets-work-orders" data-template="filters">

    <% _.each(filters, function(f) { %>

    <button class="btn btn-default btn-sm">

        <span><i class="fa fa-trash-o"></i></span>

        <% if(f.column === 'all') { %>

        <%= f.value %>

        <% } else { %>

        <%= r.value %> in <%= f.column %>

        <% } %>
    </button>

    <% }); %>

</script>
