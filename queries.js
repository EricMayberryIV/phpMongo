/**
 * Export collections
 */
mongoexport --db recColl -c vinyl --out 'export/vinyl.json'
mongoexport --db recColl -c genre --out 'export/genre.json'
mongoexport --db recColl -c company --out 'export/company.json'

/**
 * Counts for each collection
 */
db.company.count()
db.genre.count()
db.vinyl.count()

/**
 * Records that have tracks
 * Where tracks != null
 */ 
db.vinyl.find({
    "tracks": { $ne: null }
    },
    {
        "_id": 0,
        "artist": 1,
        "title": 1,
        "tracks": 1
    }
).pretty()
