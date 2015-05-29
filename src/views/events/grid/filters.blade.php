<script type="text/template" data-grid="main" data-template="filters">

    <% _.each(filters, function(f) { %>

    <li>
        <% if(column === 'all') { %>

        <%= f.value %>

        <% } else { %>

        <%= r.value %> in <%= f.column %>

        <% } %>
    </li>

    <% }); %>

</script>
