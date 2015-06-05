<script type="text/template" data-grid="parts" data-template="pagination">

    <% _.each(pagination, function(p) { %>

    <li data-grid="parts" data-page="<%= p.page %>"><%= p.page_start %> - <%= p.page_limit %></li>

    <% }); %>

</script>
