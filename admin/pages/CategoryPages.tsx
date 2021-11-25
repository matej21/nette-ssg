import { MultiEditPage, SlugField, TextField } from '@contember/admin'

export const CategoryPages = (
	<MultiEditPage pageName="categories" entities="Category" rendererProps={{
		title: "Categories"
	}}>
		<TextField field={'name'} label={'Name'}/>
		<SlugField field={'slug'} label={'URL slug'} derivedFrom={'name'} />
	</MultiEditPage>
)
