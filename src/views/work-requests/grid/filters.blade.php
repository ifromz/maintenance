<script type="text/template" data-grid="main" data-template="filters">

    <% _.each(filters, function(f) { %>

    <button class="btn btn-default btn-sm">

        <span><i class="fa fa-trash-o"></i></span>

        <% if(f.column === 'all') { %>

        <%= f.value %>

        <% } else { %>

        <%= f.value %> in <%= f.column %>

        <% } %>
    </button>

    <% }); %>

</script>
