/**
 * Export collections
 */
mongoexport --db recColl -c vinyl --out 'db/export/vinyl.json'
mongoexport --db recColl -c genre --out 'db/export/genre.json'
mongoexport --db recColl -c company --out 'db/export/company.json'

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
}, {
    "_id" : 0,
    "artist" : 1,
    "title" : 1,
    "tracks" : 1
}).pretty()

/**
 * Records that have members
 * Where members != null
 */ 
db.vinyl.find({
    "members": { $ne: null }
}, {
    "_id" : 0,
    "artist" : 1,
    "title" : 1,
    "members" : 1
}).pretty()

/**
 * List all 7" records
 */
db.vinyl.find({
    "size":7
},{_
   "_id" : 0,
   "title" : 1,
   "artist" : 1,
   "size" : 1}).pretty()

/**
 * List all records which were released since 1990
 */
db.vinyl.find({
    "year" : { 
        $gte : 1990
    }
}, { 
    "_id" : 0, 
    "title" : 1, 
    "artist" : 1, 
    "year" : 1 
}).sort({
    "year" : 1
}).pretty()

/**
 * List all records which were released before 1995
 */
db.vinyl.find({
    "year" : { 
        $lte : 1995
    }
}, { 
    "_id" : 0, 
    "title" : 1, 
    "artist" : 1, 
    "year" : 1 
}).sort({
    "year" : 1
}).pretty()

/**
 * List all records which label's name start with 'Colum'
 */
db.vinyl.find({
    "label" : {
        "$regex" : /^Colum/
    }
},{ 
    "_id" : 0, 
    "title" : 1, 
    "artist" : 1, 
    "year" : 1
}).pretty()

/** 
 * Nirvana albums released before 1992
 */
db.vinyl.find({
    "artist" : "Nirvana",
    "year" : {
        $lte : 1992
    }
},{ 
    "_id" : 0, 
    "title" : 1, 
    "artist" : 1, 
    "year" : 1
}).pretty()