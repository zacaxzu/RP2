<?php require_once __DIR__ . '/_header.php'; ?>

<h2>Settle Up Transactions</h2>

<?php if (empty($transactions)) : ?>
    <p>All balances are already settled.</p>
<?php else : ?>
    <table>
        <thead>
            <tr>
                <th>From</th>
                <th>To</th>
                <th>Amount (€)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($transaction['from']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['to']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['amount']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<form action="/balance.php?rt=newexpenses/index" method="post">
    <button type="submit">Back</button>
</form>