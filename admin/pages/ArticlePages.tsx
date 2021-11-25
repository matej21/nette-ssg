import {
    AnchorButton,
    CreatePage,
    DataBindingProvider,
    DataGrid,
    DateCell, DateField,
    DeleteEntityButton,
    EditPage,
    FeedbackRenderer,
    GenericCell,
    GenericPage,
    PageLinkButton,
    PageLinkById, RichTextField,
    SelectField, SlugField,
    TextCell,
    TextField,
    TitleBar,
} from '@contember/admin'

export const ArticleListPage = (
    <GenericPage pageName="articleList">
        <TitleBar actions={<PageLinkButton to="articleCreate">Add article</PageLinkButton>}>Articles</TitleBar>

        <DataBindingProvider stateComponent={FeedbackRenderer}>
            <DataGrid entities="Article" itemsPerPage={20}>
                <TextCell field="title" header="Title" />
                <DateCell field={'publishedAt'} header={'Published at'} initialOrder={'desc'} />
                <GenericCell canBeHidden={false} justification="justifyEnd">
                    <PageLinkById to={'articleEdit'} Component={AnchorButton}>Edit</PageLinkById>
                    <DeleteEntityButton title="Delete" immediatePersist={true}></DeleteEntityButton>
                </GenericCell>
            </DataGrid>
        </DataBindingProvider>
    </GenericPage>
)

const form = <>
    <TextField field={'title'} label={'Title'} />
    <SlugField field={'slug'} label={'URL slug'} derivedFrom={'title'}/>
    <TextField allowNewlines field={'lead'} label={'Lead'} />
    <TextField allowNewlines field={'content'} label={'Content'} />
    <DateField field={'publishedAt'} label={'Published at'} />
    <SelectField label={'Category'} field={'category'} options={'Category.name'} />
</>

export const ArticleCreatePage = (
    <CreatePage pageName={'articleCreate'} entity={'Article'} redirectOnSuccess={req => ({ ...req, pageName: 'articleList', parameters: {} })}>
        {form}
    </CreatePage>
)

export const ArticleEditPage = (
    <EditPage pageName={'articleEdit'} entity={'Article(id=$id)'} rendererProps={{
        title: 'Article',
    }}>
        {form}
    </EditPage>
)
