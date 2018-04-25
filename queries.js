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

