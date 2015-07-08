<script type="text/template" data-grid="assets" data-template="results">

    <% _.each(results, function(r){ %>

    <tr>
        <td><%= r.tag %></td>
        <td><a href="<%= r.view_url %>"><%= r.name %> </a></td>
        <td><%= r.category %></td>
        <td><%= r.location %></td>
        <td><%= r.created_at %></td>
    </tr>

    <% }); %>

</script>
