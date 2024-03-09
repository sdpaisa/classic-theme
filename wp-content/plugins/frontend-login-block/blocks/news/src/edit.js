import { useBlockProps } from "@wordpress/block-editor";
import apiFetch from "@wordpress/api-fetch"; // API
import { useState, useEffect } from "@wordpress/element"; // API
import { InspectorControls } from "@wordpress/block-editor"; // sidebar editor
import { Panel, PanelBody, SelectControl } from "@wordpress/components"; // sidebar editor

const Edit = (props) => {
  const { attributes, setAttributes } = props; // setAttributes guardar una si usamos el selector
  const { category } = attributes; // category guardar si esta guardada
  const blockProps = useBlockProps();
  const [posts, setPosts] = useState([]); // API
  const [categories, setCategories] = useState([]); // estado para guardar la categoria para renderizar el componente

  const fetchPosts = async () => {
    let path = "/wp/v2/posts"; // API
    if (category) path = path + `?categories=${category}`; // condicion para mostrat la categoria seleccionada por eso se declara como let el path
    const newPosts = await apiFetch({ path });
    setPosts(newPosts);
  };

  const fetchCategories = async () => {
    const path = "/wp/v2/categories?hide_empty=true"; // filtra las categorias vacias
    const newCategories = await apiFetch({ path }); //listar todas las categorias que tegna almenos un blog
    const filterCategories = newCategories.map((currentCategory) => {
      //generar un filtro por que no necesitamos todo
      return {
        label: currentCategory.name,
        value: currentCategory.id,
      };
    });
    setCategories(filterCategories); // guardamos dentro de la variable el resultado
  };

  useEffect(() => {
    fetchCategories();
  }, []); // API / aarray de cunado queremos que se ejecute (vacio es solo cunado se inicializa)

  useEffect(() => {
    fetchPosts();
  }, [category]); // se ejecuta una vez ucnado cambia el selector

  return (
    <>
      {/* renderizar el inspector con las categorias */}
      {categories.length > 0 && (
        <InspectorControls>
          <Panel>
            <PanelBody title="Categories" initialOpen={true}>
              <SelectControl
                label="Current Category"
                value={category || 1}
                options={categories}
                onChange={(newCategory) =>
                  setAttributes({ category: newCategory })
                }
              />
            </PanelBody>
          </Panel>
        </InspectorControls>
      )}
      {posts.length > 0 && (
        <div {...blockProps}>
          <h3>Quizás te interese leer esto:</h3>
          <ul className="posts">
            {posts.map((post) => {
              return (
                <li key={post.id}>
                  <a href={post.link}>{post.title.rendered}</a>
                </li>
              );
            })}
          </ul>
        </div>
      )}
    </>
  );
};

export default Edit;
