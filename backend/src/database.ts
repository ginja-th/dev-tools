import * as Knex from 'knex';

// Prepare the database connection
const knex: Knex = Knex(require('./../knexfile')[process.env['NODE_ENV'] || 'development']);

export default knex;