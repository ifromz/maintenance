<script type="text/template" data-grid="inventory-stocks" data-template="results">

    <% _.each(results, function(r){ %>

    <tr>
        <td><%= r.location %></td>
        <td><%= r.quantity %></td>
        <td><a class="btn btn-sm btn-primary" href="<%= r.select_url %>">Select</a></td>
    </tr>

    <% }); %>

</script>
