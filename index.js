const BigchainDB = require('bigchaindb-driver');

const API_PATH = 'https://test.bigchaindb.com/api/v1/';

// Create a new keypair.
const alice = new BigchainDB.Ed25519Keypair()

// Construct a transaction payload
const tx = BigchainDB.Transaction.makeCreateTransaction(
    // Define the asset to store, in this example it is the current temperature
    // (in Celsius) for the city of Berlin.
    { city: 'Berlin, DE', temperature: 22, datetime: new Date().toString() },

    // Metadata contains information about the transaction itself
    // (can be `null` if not needed)
    { what: 'My first BigchainDB transaction' },

    // A transaction needs an output
    [ BigchainDB.Transaction.makeOutput(
            BigchainDB.Transaction.makeEd25519Condition(alice.publicKey))
    ],
    alice.publicKey
)

// Sign the transaction with private keys
const txSigned = BigchainDB.Transaction.signTransaction(tx, alice.privateKey)

// Send the transaction off to BigchainDB
let conn = new BigchainDB.Connection(API_PATH, {
    app_id: 'c5f253ba',
    app_key: 'a9b4f9021b694736fdb463c9ba0d1d13'
})
conn.postTransactionCommit(txSigned)
    .then(res => {
        console.log("n")        
        // const elem = document.getElementById('lastTransaction')
        // elem.href = API_PATH + 'transactions/' + txSigned.id
        // elem.innerText = txSigned.id
        console.log('Transaction', txSigned.id, 'accepted')
        conn.searchAssets('Bicycle Inc.')
            .then(assets => console.log('Found assets with serial number Bicycle Inc.:', assets))
    })
// Check console for the transaction's status