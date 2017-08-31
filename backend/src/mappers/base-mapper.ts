import { BaseModel } from '../models/base-model';
import knex from './../database';

export class BaseMapper<T extends BaseModel> {

  instance: T;

  constructor(instance: T) {
    this.instance = instance;
  }

  /**
   * Returns a single instance of the model.
   * 
   * @param id 
   */
  find(id: number) {
    return this.table()
      .where({id})
      .first();
  }

  /**
   * Returns a single instance of the model.
   * 
   * @param id 
   */
  findOne(criteria: any) {

    return this.table()
      .where(criteria)
      .first();
  }

  /**
   * Returns a single instance of the model.
   * 
   * @param id 
   */
  findMany(criteria: any) {
    
    return this.table()
      .where(criteria);
  }

  /**
   * 
   */
  create() {
    return this.find(this.instance.id || 0)
      .then((row) => {
        if (row) {
          throw Error('Error trying to insert record. Id exists: ' + this.instance.id);
        }

        let target = Object.assign({}, this.instance, {
          created_at: (new Date()).toUTCString(),
          updated_at: (new Date()).toUTCString()
        });

        return this.table()
          .insert(target)
          .into(this.instance.getTable());
      })
  }

  /**
   * 
   */
  update() {
    return this.find(this.instance.id || 0)
    .then((row) => {
      if (!row) {
        throw Error('Error trying to update record. Record with id does not exist: ' + this.instance.id);
      }

      let target = Object.assign({}, this.instance, {
        updated_at: (new Date()).toUTCString()
      });

      return this.table()
        .where({id: this.instance.id})
        .update(target)
        .into(this.instance.getTable());
    })
  }
  
  /**
   * 
   */
  table() {
    return knex.table(this.instance.getTable());
  }

};