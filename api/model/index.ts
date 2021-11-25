import { SchemaDefinition as d } from '@contember/schema-definition'

export class Article {
    title = d.stringColumn().notNull()
    slug = d.stringColumn().notNull()
    lead = d.stringColumn().notNull()
    content = d.stringColumn().notNull()
    publishedAt = d.dateTimeColumn()
    category = d.manyHasOne(Category)
}

export class Category {
    name = d.stringColumn().notNull()
    slug = d.stringColumn().notNull()
}
