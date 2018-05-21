<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Correlation ID</th>
        <th scope="col">Log level</th>
        <th scope="col">Message</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($logs as $log) {
    ?>
        <tr>
            <th scope="row"><?=$log->id; ?></th>
            <td><?=$log->correlationId; ?></td>
            <td><?=$log->logLevel; ?></td>
            <td><?=$log->message; ?></td>
        </tr>
    <?php
} ?>
    </tbody>
</table>
