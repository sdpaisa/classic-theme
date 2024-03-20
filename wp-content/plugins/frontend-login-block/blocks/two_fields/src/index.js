import { registerBlockType } from "@wordpress/blocks";
import { InspectorControls } from "@wordpress/block-editor";
import { TextControl, PanelBody, PanelRow } from "@wordpress/components";
import ServerSideRender from "@wordpress/server-side-render";

registerBlockType("recetas/basic", {
  title: "Propiedades de la receta",
  description: "Agregar timepo y Cantidad de personas",
  icon: "info",
  category: "layout",
  attributes: {
    bano: {
      type: "string",
      default: "00 min",
    },
    content2: {
      type: "string",
      default: "0-0 Personas",
    },
  },
  edit: (props) => {
    const {
      attributes: { bano, content2 },
      setAttributes,
      className,
      isSelected,
    } = props;

    // Función para guardar el atributo content
    const contenidoTiempoReceta = (newContent) => {
      setAttributes({ bano: newContent });
    };
    const contenidoPersonasReceta = (newContent) => {
      setAttributes({ content2: newContent });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody // Primer panel en la sidebar
            title="Cuanto tiempo toma la receta"
            initialOpen={false}
          >
            <PanelRow>
              <TextControl
                label="Complete el campo" // Indicaciones del campo
                value={bano} // Asignación del atributo correspondiente
                onChange={contenidoTiempoReceta} // Asignación de función para gestionar el evento OnChange
              />
            </PanelRow>
          </PanelBody>

          <PanelBody // Primer panel en la sidebar
            title="Para cuantas personas es"
            initialOpen={false}
          >
            <PanelRow>
              <TextControl
                label="Complete el campo" // Indicaciones del campo
                value={content2} // Asignación del atributo correspondiente
                onChange={contenidoPersonasReceta} // Asignación de función para gestionar el evento OnChange
              />
            </PanelRow>
          </PanelBody>
        </InspectorControls>
        <ServerSideRender // Renderizado de bloque dinámico
          block="recetas/basic" // Nombre del bloque
          attributes={props.attributes} // Se envían todos los atributos
        />
      </>
    );
  },
  save: () => null,
});
