const BigchainDB = require('bigchaindb-driver');

const API_PATH = 'http://localhost:9984/api/v1/';

// Create a new keypair.
const alice = new BigchainDB.Ed25519Keypair()

// Construct a transaction payload

const assetdata = {
    'reading': {
            'timestamp': new Date(),
            'sensor'   : 'asda-dsvsvsd-213sdf-sdfsdf',
            'type'     : 'temperature',
            'reading'  : '30',
            'Altitude' : '<reading>',
            'Lattitude': '<reading>',
            'Longitude': '<reading>'
    }
}
const metadata= {'planet': 'earth'}
// Send the transaction off to BigchainDB
let conn = new BigchainDB.Connection(API_PATH, {
    app_id: 'c5f253ba',
    app_key: 'a9b4f9021b694736fdb463c9ba0d1d13'
})

const txCreateAliceSimple = BigchainDB.Transaction.makeCreateTransaction(
    assetdata,
    metadata,
    // A transaction needs an output
    [ BigchainDB.Transaction.makeOutput(
            BigchainDB.Transaction.makeEd25519Condition(alice.publicKey))
    ],
    alice.publicKey
)
txCreateAliceSimpleSigned = BigchainDB.Transaction.signTransaction(txCreateAliceSimple, alice.privateKey)
conn.postTransactionCommit(txCreateAliceSimpleSigned)


// conn.postTransactionCommit(txSigned)
//     .then(res => {
//         console.log("n")        
//         // const elem = document.getElementById('lastTransaction')
//         // elem.href = API_PATH + 'transactions/' + txSigned.id
//         // elem.innerText = txSigned.id
//         console.log('Transaction', txSigned.id, 'accepted')
//         
//     })
// Check console for the transaction's status


// conn.searchAssets('2328976')
//             .then(assets => console.log('Found :', assets))
// var data = ["2328976","b","c","d","e"];



// var processItems = function(x){
//   if( x < data.length ) {
//     const tx = BigchainDB.Transaction.makeCreateTransaction(
//         // Define the asset to store, in this example it is the current temperature
//         // (in Celsius) for the city of Berlin.
//         { city: data[x], temperature: 22, datetime: new Date().toString() },
    
//         // Metadata contains information about the transaction itself
//         // (can be `null` if not needed)
//         { what: 'My first BigchainDB transaction' },
    
//         // A transaction needs an output
//         [ BigchainDB.Transaction.makeOutput(
//                 BigchainDB.Transaction.makeEd25519Condition(alice.publicKey))
//         ],
//         alice.publicKey
//     )
    
//     // Sign the transaction with private keys
//     const txSigned = BigchainDB.Transaction.signTransaction(tx, alice.privateKey)
//     conn.postTransactionCommit(txSigned)
//     .then(res => {
//         console.log("n")        
//         // const elem = document.getElementById('lastTransaction')
//         // elem.href = API_PATH + 'transactions/' + txSigned.id
//         // elem.innerText = txSigned.id
//         console.log('Transaction', txSigned.id, 'accepted', " at ", new Date().toString())
//         processItems(x+1);    
//     })
//   }
// };

// processItems(0);
