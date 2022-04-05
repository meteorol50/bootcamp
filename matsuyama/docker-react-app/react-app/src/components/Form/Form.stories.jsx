import * as React from 'react';

import { Button } from '../Elements';

import { Form } from './Form';
import { FormDrawer } from './FormDrawer';
import { InputField } from './InputField';
import { SelectField } from './SelectField';
import { TextAreaField } from './TextareaField';

function MyForm({ hideSubmit = false }) {
  return (
    <Form
      onSubmit={async (values) => {
        alert(JSON.stringify(values, null, 2));
      }}
      id="my-form"
    >
      {({ register, formState }) => (
        <>
          <InputField
            label="Title"
            error={formState.errors.title}
            registration={register('title')}
          />
          <TextAreaField
            label="Description"
            error={formState.errors.description}
            registration={register('description')}
          />
          <SelectField
            label="Team"
            error={formState.errors.type}
            registration={register('type')}
            options={['A', 'B', 'C'].map((type) => ({
              label: type,
              value: type,
            }))}
          />

          {!hideSubmit && (
            <div>
              <Button type="submit" className="w-full">
                Submit
              </Button>
            </div>
          )}
        </>
      )}
    </Form>
  );
}

const meta = {
  title: 'Components/Form',
  component: MyForm,
  parameters: {
    controls: { expanded: true },
  },
};

export default meta;

function Template() {
  return <MyForm />;
}

export const Default = Template.bind({});
Default.args = {};

export function AsFormDrawer() {
  return (
    <FormDrawer
      triggerButton={<Button>Open Form</Button>}
      isDone
      title="My Form"
      size="lg"
      submitButton={(
        <Button form="my-form" type="submit">
          Submit
        </Button>
      )}
    >
      <MyForm hideSubmit />
    </FormDrawer>
  );
}
